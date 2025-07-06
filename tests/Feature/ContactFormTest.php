<?php

namespace Tests\Feature;

use App\Mail\ContactUs;
use App\Http\Controllers\User\UserContactController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_does_not_send_email_with_empty_name()
    {
        $formData = $this->invalidFormData(['name' => '']);

        $this->assertFormSubmissionDoesNotSendEmail($formData);
    }

    public function test_contact_form_does_not_send_email_with_empty_email()
    {
        $formData = $this->invalidFormData(['email' => '']);

        $this->assertFormSubmissionDoesNotSendEmail($formData);
    }

    public function test_contact_form_does_not_send_email_with_empty_subject()
    {
        $formData = $this->invalidFormData(['subject' => '']);

        $this->assertFormSubmissionDoesNotSendEmail($formData);
    }

    public function test_contact_form_does_not_send_email_with_empty_message()
    {
        $formData = $this->invalidFormData(['message' => '']);

        $this->assertFormSubmissionDoesNotSendEmail($formData);
    }

    public function test_contact_form_sends_email_with_valid_data()
    {
        $formData = $this->validFormData();

        $this->assertFormSubmissionDoesSendEmail($formData);
    }

    protected function invalidFormData(array $overrides = [])
    {
        return array_merge([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test Message',
        ], $overrides);
    }

    protected function validFormData()
    {
        return [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test Message',
        ];
    }

    protected function assertFormSubmissionDoesNotSendEmail(array $formData)
    {
        Mail::fake();
        $response = $this->post(route('send.email'), $formData);

        $response->assertRedirect()
            ->assertSessionHasErrors(array_keys(array_filter($formData)));

        Mail::assertNotSent(ContactUs::class);
    }

    protected function assertFormSubmissionDoesSendEmail(array $formData)
    {
        Mail::fake();

        $response = $this->post(route('send.email'), $formData);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Laiškas sėkmingai išsiųstas!');

        Mail::assertSent(ContactUs::class);
    }
}
