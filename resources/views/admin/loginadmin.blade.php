<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<form method="POST" action="/login">
    @csrf

<form class="p-4">
  <div class="mb-3">
    <label>Username</label>
    <input type="text" name="name" class="form-control" placeholder="email@example.com">
  </div>

  <div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control" placeholder="Password">
  </div>

  <div class="form-check mb-3">
    <input type="checkbox" class="form-check-input">
    <label class="form-check-label">Remember me</label>
  </div>

  <button type="submit" class="btn btn-primary w-100">
    Sign in
  </button>
  @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif
</form>
