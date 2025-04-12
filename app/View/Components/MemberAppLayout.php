<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MemberAppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('member.layouts.app');
    }
}
