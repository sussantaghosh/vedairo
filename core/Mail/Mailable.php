<?php namespace Vedairo\Mail; interface Mailable {public function to():string;public function subject():string;public function html():string;public function text():string;}
