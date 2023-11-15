<?php

namespace App\Mail;

use App\Models\Category;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class CategoryCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function build()
    {
        $userName = $this->category->creator->name;
        return $this->subject('Welcome to YourApp')
            ->markdown('emails.category_created_markdown', ['userName' => $userName]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Category Created Mail',
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
