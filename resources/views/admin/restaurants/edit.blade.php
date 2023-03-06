@extends('layouts.app')

@section('title')
    | Edit {{ $restaurant->name }}
@endsection

@section('content')
    <div class="container">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.dashboard') }}" title="Go back" class="btn btn-outline-dark my-5 me-5">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="name-pc-tablet text-capitalize">
                Modifica {{ $restaurant->name }}
            </h1>
        </div>
        <h1 class="name-mobile mb-5 text-capitalize">
            Modifica {{ $restaurant->name }}
        </h1>

        <div class="container p-0">


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

            <form action="{{ route('admin.restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data"
                id="restaurant-edit" onsubmit="return handleData()">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nome *</label>
                    <input category="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $restaurant->name) }}" placeholder="Aggiungi nome..." required
                        autocomplete="name" autofocus minlength="2" maxlength="100"
                        title="Campo obbligatorio, inserire almeno 2 caratteri"
                        oninvalid="this.setCustomValidity('Campo obbligatorio, inserire almeno 2 caratteri ed un massimo di 100.')"
                        onchange="this.setCustomValidity('')">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Indirizzo *</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                        name="address" value="{{ old('address', $restaurant->address) }}" placeholder="Aggiungi indirizzo..."
                        required minlength="8" maxlength="100" autocomplete="address" autofocus
                        oninvalid="this.setCustomValidity('Campo obbligatorio, inserire un indirizzo valido.')"
                        onchange="this.setCustomValidity('')">
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="img" class="form-label">Immagine</label>
                    <input type="file" id="file" onchange="fileValidation()"
                        class="form-control @error('img') is-invalid @enderror" id="img" name="img"
                        value="{{ old('img', $restaurant->img) }}" placeholder="Add URL for image..."
                        oninput="showCoverImg(event)">

                    <p class="my-1" id="size-message"></p>

                    @error('img')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    @if ($restaurant->img)
                        <div id="image-box" class="cover-image mt-3">
                            <img class="w-25" src="{{ asset('storage/' . $restaurant->img) }}"
                                alt="{{ $restaurant->img_original_name }}">
                        </div>
                    @endif

                    <div id="img-changed" class="cover-image mt-3"></div>
                </div>

                <div class="mb-3">
                    <label for="telephone" class="form-label">Telefono *</label>
                    <input type="phone" class="form-control @error('telephone') is-invalid @enderror" id="telephone"
                        name="telephone" value="{{ old('telephone', $restaurant->telephone) }}"
                        placeholder="Aggiungi numero telefonico..." required autocomplete="telephone" autofocus
                        title="Campo obbligatorio, inserire un numero di telefono valido" minlength="5"
                        pattern="[0-9-+\s()]{5,20}"
                        oninvalid="this.setCustomValidity('Campo obbligatorio, inserire un numero di telefono valido.')"
                        onchange="this.setCustomValidity('')">
                    @error('telephone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="iva" class="form-label">Partita IVA *</label>
                    <input type="text" class="form-control @error('iva') is-invalid @enderror" id="iva"
                        name="iva" value="{{ old('iva', $restaurant->iva) }}" placeholder="Aggiungi partita IVA..."
                        required autocomplete="iva" autofocus pattern="[0-9]{11}"
                        title="Campo obbligatorio, inserire una p.iva valida composta da 11 cifre"
                        oninvalid="this.setCustomValidity('Campo obbligatorio, richiede un numero di 11 cifre.')"
                        onchange="this.setCustomValidity('')">
                    @error('iva')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 row">
                    <label for="categories" class="col-md-4 col-form-label text-md-right mb-1">Categorie *</label>
                    <p class="text-danger mb-1" style="visibility:hidden; font-size:0.9rem;" id="checkbox-error">
                        Selezionare almeno una categoria.
                    </p>
                    <div class="row px-4">
                        @foreach ($categories as $category)
                            <div class="col-4  col-sm-3 col-xl-2 form-check">
                                <input class="form-check-input" type="checkbox" id="{{ $category->slug }}"
                                    value="{{ $category->id }}" name="categories[]"
                                    oninvalid="this.setCustomValidity('Selezionare almeno una categoria.')"
                                    onchange="this.setCustomValidity('')"
                                    @if (!$errors->all() && $restaurant->categories->contains($category)) checked @elseif($errors->all() && in_array($category->id, old('categories', []))) checked @endif>
                                <label class="form-check-label"
                                    for="{{ $category->slug }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button category="submit" class="btn btn-dark mb-5">Invia
                    <i class="fa-solid fa-file-import"></i>
                </button>
            </form>
        </div>

        <script>
            //Show thumbnail of file image uploaded
            function showCoverImg(event) {
                document.getElementById("img-changed").innerHTML =
                    `<img class="w-25" id="output-image" src="">`;
                document.getElementById("output-image").src = URL.createObjectURL(event.target.files[0]);

                let imageBox = document.getElementById("image-box");
                if (imageBox) {
                    imageBox.innerHTML = ``;
                }
            }


            //On submit validation for checkbox and image size
            function handleData() {
                return (checkBoxValidation() && fileValidation())
            }

            //Checkbox validation with error message
            function checkBoxValidation() {
                const form_data = new FormData(document.getElementById("restaurant-edit"));
                const errorCheckbox = document.getElementById("checkbox-error");
                if (!form_data.has("categories[]")) {
                    errorCheckbox.style.visibility = "visible";
                    return false;
                }
                errorCheckbox.style.visibility = "hidden";
                return true;

            }

            //File size image validation with error message
            function fileValidation() {
                const inputFiles = document.getElementById('file');
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
    </div>
@endsection
