@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registazione') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" id="restaurant-form"
                            onsubmit="return handleData()" enctype="multipart/form-data">
                            @csrf

                            {{-- User name --}}
                            <div class="mb-4 row">
                                <label for="name" class="col-md-4 col-form-label text-md-right"><i
                                        class="fa-solid fa-user"></i> {{ __('Nome') }} *</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" placeholder="Scrivi qui il tuo nome" required
                                        autocomplete="name" autofocus minlength="2" maxlength="100"
                                        title="Campo obbligatorio, inserire almeno 2 caratteri"
                                        oninvalid="this.setCustomValidity('Campo obbligatorio, inserire almeno 2 caratteri')"
                                        onchange="this.setCustomValidity('')">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- User e-mail --}}
                            <div class="mb-4 row">
                                <label for="email" class="col-md-4 col-form-label text-md-right"><i
                                        class="fa-solid fa-envelope"></i> {{ __('Indirizzo E-mail') }} *</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="Scrivi qui il tuo indirizzo e-mail"
                                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required autocomplete="email"
                                        title="Campo obbligatorio, inserire una e-mail valida" minlength="6"
                                        oninvalid="this.setCustomValidity('Campo obbligatorio, inserire una e-mail valida')"
                                        onchange="this.setCustomValidity('')">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- User password --}}
                            <div class="mb-4 row">
                                <label for="password" class="col-md-4 col-form-label text-md-right"><i
                                        class="fa-solid fa-lock"></i> {{ __('Password') }} *</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Scrivi qui la password scelta" required autocomplete="new-password"
                                        minlength="8"
                                        title="Campo obbligatorio, inserire una password di almeno 8 caratteri"
                                        oninvalid="this.setCustomValidity('Campo obbligatorio, inserire una password di almeno 8 caratteri.')"
                                        onchange="this.setCustomValidity('')">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- User confirm password --}}
                            <div class="mb-4 row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right"><i
                                        class="fa-solid fa-lock"></i> {{ __('Conferma Password') }} *</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" placeholder="Riscrivi qui la password inserita"
                                        required autocomplete="new-password" title="Campo obbligatorio"
                                        oninvalid="this.setCustomValidity('Campo obbligatorio, reinserire la password.')"
                                        onchange="this.setCustomValidity('')">
                                </div>
                            </div>

                            {{-- Restaurant name --}}
                            <div class="mb-4 row">
                                <label for="restaurant_name" class="col-md-4 col-form-label text-md-right"><i
                                        class="fa-solid fa-utensils"></i> {{ __('Nome Ristorante') }} *</label>

                                <div class="col-md-6">
                                    <input id="restaurant_name" type="text"
                                        class="form-control @error('restaurant_name') is-invalid @enderror"
                                        name="restaurant_name" value="{{ old('restaurant_name') }}"
                                        placeholder="Scrivi qui il nome del ristorante" required
                                        autocomplete="restaurant_name" autofocus minlength="2" maxlength="100"
                                        title="Campo obbligatorio, inserire almeno 2 caratteri"
                                        oninvalid="this.setCustomValidity('Campo obbligatorio, inserire almeno 2 caratteri ed un massimo di 100.')"
                                        onchange="this.setCustomValidity('')">

                                    @error('restaurant_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Restaurant P.IVA --}}
                            <div class="mb-4 row">
                                <label for="iva" class="col-md-4 col-form-label text-md-right"><i
                                        class="fa-solid fa-hashtag"></i> {{ __('P. IVA') }} *</label>

                                <div class="col-md-6">
                                    <input id="iva" type="text"
                                        class="form-control @error('iva') is-invalid @enderror" name="iva"
                                        value="{{ old('iva') }}"
                                        placeholder="Scrivi qui la partita IVA del ristorante" required autocomplete="iva"
                                        autofocus pattern="[0-9]{11}"
                                        title="Campo obbligatorio, inserire una p.iva valida composta da 11 cifre"
                                        oninvalid="this.setCustomValidity('Campo obbligatorio, richiede un numero di 11 cifre.')"
                                        onchange="this.setCustomValidity('')">

                                    @error('iva')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Restaurant address --}}
                            <div class="mb-4 row">
                                <label for="address" class="col-md-4 col-form-label text-md-right"><i
                                        class="fa-solid fa-location-dot"></i> {{ __('Indirizzo Ristorante') }} *</label>

                                <div class="col-md-6">
                                    <input id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ old('address') }}"
                                        placeholder="Scrivi qui l'indirizzo es. Via Rossi, 25, Roma (RM)" required
                                        title="Campo obbligatorio, inserire un indirizzo valido" minlength="8"
                                        maxlength="100" autocomplete="address" autofocus
                                        oninvalid="this.setCustomValidity('Campo obbligatorio, inserire un indirizzo valido.')"
                                        onchange="this.setCustomValidity('')">

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Restaurant telephone --}}
                            <div class="mb-4 row">
                                <label for="telephone" class="col-md-4 col-form-label text-md-right"><i
                                        class="fa-solid fa-phone"></i> {{ __('Numero di Telefono') }} *</label>

                                <div class="col-md-6">
                                    <input id="telephone" type="phone"
                                        class="form-control @error('telephone') is-invalid @enderror" name="telephone"
                                        value="{{ old('telephone') }}"
                                        placeholder="Scrivi qui il numero di telefono del ristorante" required
                                        autocomplete="telephone" autofocus
                                        title="Campo obbligatorio, inserire un numero di telefono valido"
                                        pattern="[0-9-+\s()]{5,20}"
                                        oninvalid="this.setCustomValidity('Campo obbligatorio, inserire un numero di telefono valido.')"
                                        onchange="this.setCustomValidity('')">

                                    @error('telephone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Restaurant categories --}}
                            <div class="mb-4 row">
                                <label for="categories" class="col-md-4 col-form-label text-md-right mb-1"><i
                                        class="fa-solid fa-tags"></i> Categorie *</label>
                                <p class="text-danger mb-1" style="visibility:hidden; font-size:0.9rem;"
                                    id="checkbox-error">
                                    Selezionare almeno un'opzione.
                                </p>
                                <div class="row px-4">
                                    @foreach ($categories as $category)
                                        <div class="col-4  col-sm-3 col-xl-2 form-check">
                                            <input class="form-check-input" type="checkbox" id="{{ $category->slug }}"
                                                value="{{ $category->id }}" name="categories[]"
                                                oninvalid="this.setCustomValidity('Selezionare almeno una categoria.')"
                                                onchange="this.setCustomValidity('')"
                                                @if (in_array($category->id, old('categories', []))) checked @endif>
                                            <label class="form-check-label"
                                                for="{{ $category->slug }}">{{ $category->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            {{-- Registration button --}}
                            <div class="mb-4 row">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-outline-dark">
                                        {{ __('Registrati') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        //Checkbox validation with error message
        function handleData() {
            const form_data = new FormData(document.getElementById("restaurant-form"));
            const errorCheckbox = document.getElementById("checkbox-error");
            if (form_data.get('password') !== form_data.get('password_confirmation')) {
                const password_confirmation = document.getElementById('password-confirm');
                password_confirmation.setCustomValidity("Le password non coincidono");
                return false
            }
            if (!form_data.has("categories[]")) {
                errorCheckbox.style.visibility = "visible";
                return false
            } else {
                errorCheckbox.style.visibility = "hidden";
            }
            return true
        }
    </script>
@endsection
