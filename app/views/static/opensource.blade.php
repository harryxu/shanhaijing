@extends('layouts.master')

@section('title')
Open Source - @parent
@stop

@section('content')
  <section>
    <h1>Open Source</h1>
    <p>Shanhaijin is build on top of laravel framework and many open source projects:</p>
    <ul>
      <li><a href="http://laravel.com/" target="_blank">laravel</a> The web framework.</li>
      <li><a href="http://php.net/" target="_blank">php</a> The language.</li>
      <li><a href="https://github.com/cartalyst/sentry" target="_blank">Sentry</a> A framework agnostic authentication & authorization system.</li>
      <li><a href="http://jquery.com" target="_blank">jQuery</a> Awesome JavaScript library.</li>
      <li><a href="http://twitter.github.io/bootstrap/" target="_blank">Bootstrap</a> Sleek, intuitive, and powerful front-end framework.</li>
      <li><a href="http://aozora.github.io/bootplus/" target="_blank">Bootplus</a> Sleek, intuitive, and powerful Google styled front-end framework.</li>
      <li><a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome</a> The iconic font designed for Bootstrap.</li>
      <li><a href="http://parsleyjs.org/" target="_blank">Parsley.js</a> Javascript forms validation.</li>
      <li><a href="https://code.google.com/p/html5shiv/" target="_blank">html5shiv</a> HTML5 IE enabling script.</li>
      <li><a href="https://code.google.com/p/pagedown/" target="_blank">PageDown</a> A JavaScript Markdown converter and editor.</li>
      <li><a href="https://github.com/dflydev/dflydev-markdown" target="_blank">dflydev-markdown</a> PHP Markdown & Extra</li>
      <li><a href="http://htmlpurifier.org/" target="_blank">HTML Purifier</a> Standards-Compliant HTML Filtering</li>
    </ul>
  </section>
@stop
