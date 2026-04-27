<?php

it('loads the homepage successfully', function () {
    $this->get(route('home'))->assertOk()->assertSeeLivewire('frontend.hero-slider');
});

it('shows services section', function () {
    $this->get(route('home'))->assertSeeLivewire('frontend.services-grid');
});

it('shows latest posts section', function () {
    $this->get(route('home'))->assertSeeLivewire('frontend.latest-posts');
});
