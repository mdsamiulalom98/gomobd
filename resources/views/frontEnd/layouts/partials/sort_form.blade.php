<form class="sort-form">
    <select name="sort" class="form-control form-select" onchange="this.form.submit()">
        <option value="1" @if (request()->get('sort') == 1) selected @endif>
            Product: Latest</option>
        <option value="2" @if (request()->get('sort') == 2) selected @endif>
            Product: Oldest</option>
        <option value="3" @if (request()->get('sort') == 3) selected @endif>
            Price: High To Low</option>
        <option value="4" @if (request()->get('sort') == 4) selected @endif>
            Price: Low To High</option>
        <option value="5" @if (request()->get('sort') == 5) selected @endif>
            Name: A-Z</option>
        <option value="6" @if (request()->get('sort') == 6) selected @endif>
            Name: Z-A</option>
    </select>
    <input type="hidden" name="page" value="{{ request()->page }}">
</form>