<?php

namespace Tests\Feature;

use App\Mail\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_message_is_sent_to_support(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.send'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Order question',
            'message' => 'Please help with my order.',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        Mail::assertSent(ContactMessage::class, function (ContactMessage $mail) {
            return $mail->name === 'Jane Doe'
                && $mail->email === 'jane@example.com'
                && $mail->mailSubject === 'Order question'
                && $mail->body === 'Please help with my order.';
        });
    }

    public function test_contact_message_requires_valid_input(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.send'), [
            'name' => '',
            'email' => 'not-an-email',
            'subject' => '',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
        Mail::assertNothingSent();
    }
}
