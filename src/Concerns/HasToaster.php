<?php

namespace Nawasara\Toaster\Concerns;

trait HasToaster
{
    /**
     * Dispatch a browser toast event from Livewire component.
     * Usage: $this->alert('success', 'Saved successfully');
     *
     * @param string $type
     * @param string $message
     * @param array $options
     * @return void
     */
    public function alert(string $type, string $message, array $options = []): void
    {
        $payload = array_merge([
            'type' => $type,
            'message' => $message,
            'duration' => $options['duration'] ?? null,
            'showProgress' => $options['showProgress'] ?? null,
        ], $options);

        // If this is a Livewire component, dispatch browser event so the client-side toaster receives it
        if (class_exists('\\Livewire\\Component') && $this instanceof \Livewire\Component) {
            // Use Livewire's browser event helper
            info($payload);
            $this->dispatch('toast', $payload);
            return;
        }

        // Fallback: flash to session so script init can pick it up on next full page load
        session()->flash('toast', [
            'type' => $type,
            'message' => $message,
            'options' => $options,
        ]);
    }
}
