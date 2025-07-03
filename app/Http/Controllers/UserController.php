<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of all users (Owner only).
     */
    public function index(Request $request)
    {
        // Check if user is an owner
        if (!Auth::user() || !Auth::user()->isOwner()) {
            abort(403, 'Unauthorized. Only owners can view all users.');
        }

        // Build query with search and filters
        $query = User::with(['student', 'teacher', 'contact']);

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Get paginated results
        $users = $query->orderBy('name')->paginate(20);

        // Preserve query parameters in pagination links
        $users->appends($request->query());

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        if (!Auth::user() || !Auth::user()->isOwner()) {
            abort(403, 'Unauthorized. Only owners can create users.');
        }

        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isOwner()) {
            abort(403, 'Unauthorized. Only owners can create users.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:Student,Teacher,Schedule_admin,Owner',
            'email' => 'required_unless:role,Student|email|unique:contacts,email',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'boolean',
            'comment' => 'nullable|string|max:1000'
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'is_active' => $request->has('is_active'),
            'comment' => $request->comment,
        ]);

        // If the user is a student, create student record and contact with school email
        if ($request->role === 'Student') {
            $this->createStudentRecords($user);
        } else {
            // For non-student users, create contact record with provided email
            $user->contact()->create([
                'email' => $request->email,
                'is_active' => $user->is_active,
            ]);
        }

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.' .
                ($request->role === 'Student' ? ' Student number and school email generated automatically.' : ''));
    }

    /**
     * Create student records with auto-generated student number and school email.
     */
    private function createStudentRecords(User $user)
    {
        // Generate unique student number
        $studentNumber = $this->generateUniqueStudentNumber();

        // Create student record with default values
        $student = $user->student()->create([
            'student_number' => $studentNumber,
            'class' => 'Unassigned', // Default class value
            'birth_date' => '2000-01-01', // Default birth date - can be updated later
            'is_active' => $user->is_active,
        ]);

        // Create contact record with school email
        $schoolEmail = $studentNumber . '@school.com';
        $user->contact()->create([
            'email' => $schoolEmail,
            'is_active' => $user->is_active,
        ]);
    }

    /**
     * Generate a unique student number.
     */
    private function generateUniqueStudentNumber()
    {
        return Student::generateUniqueStudentNumber();
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        if (!Auth::user() || !Auth::user()->isOwner()) {
            abort(403, 'Unauthorized. Only owners can view user details.');
        }

        $user->load(['student', 'teacher', 'contact']);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        if (!Auth::user() || !Auth::user()->isOwner()) {
            abort(403, 'Unauthorized. Only owners can edit users.');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        if (!Auth::user() || !Auth::user()->isOwner()) {
            abort(403, 'Unauthorized. Only owners can update users.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:Student,Teacher,Schedule_admin,Owner',
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'boolean',
            'comment' => 'nullable|string|max:1000'
        ]);

        $oldRole = $user->role;

        $updateData = [
            'name' => $request->name,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
            'comment' => $request->comment,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $user->update($updateData);

        // Handle role changes for students
        if ($oldRole !== $request->role) {
            // If changing TO student role and no student record exists
            if ($request->role === 'Student' && !$user->student) {
                $this->createStudentRecords($user);
            }

            // If changing FROM student role, you might want to deactivate student record
            // but keep it for historical purposes (optional)
            if ($oldRole === 'Student' && $request->role !== 'Student' && $user->student) {
                $user->student->update(['is_active' => false]);
            }
        }

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.' .
                ($oldRole !== $request->role && $request->role === 'Student' ? ' Student number and school email generated automatically.' : ''));
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if (!Auth::user() || !Auth::user()->isOwner()) {
            abort(403, 'Unauthorized. Only owners can delete users.');
        }

        // Prevent owners from deleting themselves
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user active status.
     */
    public function toggleActive(User $user)
    {
        if (!Auth::user() || !Auth::user()->isOwner()) {
            abort(403, 'Unauthorized. Only owners can toggle user status.');
        }

        $user->update(['is_active' => !$user->is_active]);

        return redirect()->route('users.index')
            ->with('success', 'User status updated successfully.');
    }
}
