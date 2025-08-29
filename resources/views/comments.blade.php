<div class="fc-wrapper">
    <div class="fc-header">test12344365567</div>

    @if (auth()->user()->can('create', \Parallax\FilamentComments\Models\FilamentComment::class))
        <div class="fc-form-wrapper">
            {{ $this->form }}
            
            <x-filament::button
                wire:click="create"
                color="primary"
                class="fc-add-button"
            >
                {{ __('filament-comments::filament-comments.comments.add') }}
            </x-filament::button>
        </div>
    @endif

    @if (count($comments))
        <x-filament::section class="fc-comments-section">
            @foreach ($comments as $comment)
                <div class="fc-comment-card">
                    <div class="fc-comment-inner">
                        @if (config('filament-comments.display_avatars'))
                            <x-filament-panels::avatar.user size="md" :user="$comment->user" class="fc-avatar" />
                        @endif

                        <div class="fc-comment-body">
                            <div class="fc-comment-header">
                                <div class="fc-comment-userinfo">
                                    <div class="fc-username">
                                        {{ $comment->user[config('filament-comments.user_name_attribute')] }}
                                    </div>

                                    <div class="fc-timestamp">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                @if (auth()->user()->can('delete', $comment))
                                    <div class="fc-delete">
                                        <x-filament::icon-button
                                            wire:click="delete({{ $comment->id }})"
                                            icon="{{ config('filament-comments.icons.delete') }}"
                                            color="danger"
                                            tooltip="{{ __('filament-comments::filament-comments.comments.delete.tooltip') }}"
                                            class="fc-delete-button"
                                        />
                                    </div>
                                @endif
                            </div>

                            <div class="fc-comment-text">
                                @if(config('filament-comments.editor') === 'markdown')
                                    {{ Str::of($comment->comment)->markdown()->toHtmlString() }}
                                @else
                                    {{ Str::of($comment->comment)->toHtmlString() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </x-filament::section>
    @else
        <div class="fc-empty">
            <x-filament::icon
                icon="{{ config('filament-comments.icons.empty') }}"
                class="fc-empty-icon"
            />
            
            <div class="fc-empty-text">
                {{ __('filament-comments::filament-comments.comments.empty') }}
            </div>
        </div>
    @endif
</div>
