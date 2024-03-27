<?php

namespace App\Domain\Blog\Notifications;

use sethsharp\Models\Blog\Blog;
use sethsharp\Models\Blog\Comment;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\SlackMessage;
use Illuminate\Notifications\Slack\BlockKit\Blocks\ActionsBlock;
use Illuminate\Notifications\Slack\BlockKit\Blocks\SectionBlock;

class NotifySlackOfCommentNotification extends Notification
{
    public function __construct(
        public Comment $comment,
        public Blog    $blog
    ) {
    }

    public function via($notifiable): array
    {
        return ['slack'];
    }

    public function toSlack(object $notifiable): SlackMessage
    {
        return (new SlackMessage())
            ->text('New comment on your blog!')
            ->headerBlock('New comment on your blog - ' . $this->blog->title)
            ->sectionBlock(function (SectionBlock $block) use ($notifiable) {
                $block->field("Name: " . $notifiable->name)->markdown();
                $block->field("Email: " . $notifiable->email)->markdown();
            })
            ->actionsBlock(function (ActionsBlock $block) use ($notifiable) {
                $block->button('View Here')->url(route('blogs.show', $this->blog));
            })
            ->dividerBlock()
            ->sectionBlock(function (SectionBlock $block) use ($notifiable) {
                $block->text($this->comment['comment']);
            });
    }
}
