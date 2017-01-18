From: {{ $name }} &lt;{{ $email }}&gt;<br>
@if (isset($phone))
	Phone: {{ $phone }}<br>
@endif
<br>
<pre>
{{ $message }}
</pre>
