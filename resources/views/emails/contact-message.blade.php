<p>You received a new contact form submission from Seven Sisters Wear.</p>

<p><strong>Name:</strong> {{ $name }}</p>
<p><strong>Email:</strong> {{ $email }}</p>
<p><strong>Subject:</strong> {{ $mailSubject }}</p>

<p><strong>Message:</strong></p>
<p>{!! nl2br(e($body)) !!}</p>
