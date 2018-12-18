<div>Tesing User Profile page.. {{ Auth::user()->category }}</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST">
    {{ csrf_field() }}
    <input type="submit" value="logout">
</form>