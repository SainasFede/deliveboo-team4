<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-{{ $entity->id }}">
    <i class="fa-solid fa-trash-can"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="modal-{{ $entity->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminazione prodotto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Confermi l'eliminazione di <span class="text-capitalize">{{$entity->name}}</span> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Annulla</button>
                <form class="d-inline" action="{{ route('admin.' . $route . '.destroy', $entity) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" title="delete" type="submit">
                        Conferma
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

