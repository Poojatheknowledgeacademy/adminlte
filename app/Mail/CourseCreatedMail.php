<?php

namespace App\Mail;


use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class CourseCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $course;
    /**
     * Create a new message instance.
     */
    public function __construct(Course $course)
    {
       $this->course = $course;
    }
    public function build()
    {
        $userName = $this->course->creator->name;
        return $this->subject('Welcome to YourApp')
            ->markdown('emails.course_created_markdown', ['userName' => $userName]);


    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Course Created Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
           // view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
