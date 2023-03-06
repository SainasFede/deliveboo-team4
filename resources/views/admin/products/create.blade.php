@extends('layouts.app')

@section('title')
    | Crea prodotto
@endsection

@section('content')
    <div class="container">

        @include('admin.partials.action-in-page')
        <h1 class="name-mobile mb-5">Crea un nuovo prodotto</h1>

        @if ($errors->any())
            <div class="alert alert-danger m-5" role="alert">
                <h2><i class="fa-solid fa-triangle-exclamation"></i>Error</h2>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return fileValidation()">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nome *</label>
                <input required type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    name="name" placeholder="Aggiungi nome..." minlength="2" maxlength="100" value="{{ old('name') }}"
                    oninvalid="this.setCustomValidity('Campo obbligatorio, richiede almeno 2 caratteri')"
                    oninput="this.setCustomValidity('')">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Prezzo *</label>
                <input required type="number" min="0.01" max="999.99" step=0.01
                    class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                    placeholder="Aggiungi prezzo..." value="{{ old('price') }}" oninvalid="InvalidMsg(this);"
                    oninput="InvalidMsg(this);">
                @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="img" class="form-label">Immagine</label>
                <input type="file" class="form-control @error('img') is-invalid @enderror" id="img" name="img"
                    placeholder="Aggiungi immagine..." onchange="showImage(event); fileValidation()" value="{{ old('img') }}">

                <p class="my-1" id="size-message"></p>

                <div id="cover-image" class="cover-image mt-3" oninput="showCoverImg()"></div>

                @error('img')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="is_visible" class="form-label">Visibilità *</label>
                <select required class="form-select" name="is_visible" class="@error('is_visible') is-invalid @enderror"
                    id="is_visible" oninvalid="this.setCustomValidity('Campo obbligatorio')"
                    oninput="this.setCustomValidity('')">
                    <option value="1" default>Il prodotto sarà visibile sul sito</option>
                    <option value="0">Il prodotto NON sarà visibile sul sito</option>
                </select>
                @error('is_visible')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrizione *</label>
                <textarea required class="form-control" id="description-todo" name="description" rows="5"
                    placeholder="Aggiungi descrizione..." oninvalid="this.setCustomValidity('Campo obbligatorio')"
                    oninput="this.setCustomValidity('')">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-dark mb-5">Invia
                <i class="fa-solid fa-file-import"></i>
            </button>
        </form>

    </div>

    <script>
        document.getElementById("img").addEventListener("input", showCoverImg);

        // ClassicEditor
        //     .create(document.querySelector('#description'), {
        //         toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
        //     })
        //     .catch(error => {
        //         console.error(error);
        //     });

        function showCoverImg() {
            document.getElementById("cover-image").innerHTML = `<img class="w-25" id="output-image" src="" alt="">`;
        }

        function showImage(event) {
            const tagImage = document.getElementById('output-image');
            tagImage.src = URL.createObjectURL(event.target.files[0]);
        }

        function InvalidMsg(textbox) {
            if (textbox.value === '') textbox.setCustomValidity('Campo obbligatorio');
            else if (textbox.validity.rangeOverflow) textbox.setCustomValidity(
                'Il prezzo deve essere al massimo di 999.99');
            else if (textbox.validity.rangeUnderflow) textbox.setCustomValidity(
                'Il prezzo deve essere minimo di 0.01');
            else textbox.setCustomValidity('');

            return true;
        }

        //File size image validation with error message
        function fileValidation() {
            const inputFiles = document.getElementById('img');
            // Check if any file is selected.
            if (inputFiles.files.length > 0) {
                for (const i = 0; i <= inputFiles.files.length - 1; i++) {
                    const fileSize = inputFiles.files.item(i).size;
                    const file = Math.round((fileSize / 1024));
                    const errorMessage = document.getElementById('size-message');
                    // The size of the file.
                    if (file >= 3072) {
                        errorMessage.classList.add("text-danger");
                        errorMessage.classList.add("fw-bold");
                        errorMessage.innerText = 'File troppo grande, inserirlo al massimo di 3MB!';
                        errorMessage.scrollIntoView();
                        return false
                    } else {
                        errorMessage.classList.remove("text-danger");
                        errorMessage.classList.add("fw-bold");
                        errorMessage.innerText = "";
                        return true
                    }
                }
            }
            return true
        }
    </script>
@endsection
