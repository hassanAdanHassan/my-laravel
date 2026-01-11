 <form action="{{ route('groupCategory.destroy', $category->id) }}"
     method="POST" class="btn btn-danger btn-sm">
     @csrf
     <button type="submit" class="btn btn-danger btn-sm"
         onclick="return confirm('Are you sure you want to delete this category {{ $group->name }}?')">
         Delete
     </button>
 </form>



    <form action="{{ route('groupCategory.destroy', $group->id) }}"
     method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onsubmit="return confirm('Are you sure you want to delete this group?')">delete</button>
                                    </form>