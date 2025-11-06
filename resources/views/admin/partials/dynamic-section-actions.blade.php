<div class="btn-group" role="group">
    <a href="{{ $edit }}" class="btn btn-sm btn-primary">
        <i class="fas fa-edit"></i> Edit
    </a>
    <a href="{{ $manage }}" class="btn btn-sm btn-info">
        <i class="fas fa-list"></i> Manage Posts
    </a>
    <form action="{{ $delete }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this section?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Delete
        </button>
    </form>
</div>
