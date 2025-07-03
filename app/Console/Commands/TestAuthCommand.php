<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class TestAuthCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:auth {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test authentication with email from Contact table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $this->info("Testing authentication with email: {$email}");

        // Test finding user by email
        $user = User::findByEmail($email);
        if ($user) {
            $this->info("✓ User found: {$user->name}");
            $this->info("✓ Role: {$user->role}");
            $this->info("✓ Contact email: {$user->email}");

            // Test authentication
            $contact = Contact::where('email', $email)->first();
            if ($contact) {
                $this->info("✓ Contact record found");
                $this->info("✓ Phone: {$contact->phone}");
                $this->info("✓ City: {$contact->city}");
            }
        } else {
            $this->error("✗ User not found");
        }

        // List all users
        $this->info("\nAll users with their emails:");
        $users = User::with('contact')->get();
        foreach ($users as $user) {
            $email = $user->contact?->email ?? 'No email';
            $this->line("- {$user->name} ({$user->role}): {$email}");
        }
    }
}
