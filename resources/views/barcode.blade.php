@extends('app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12 mt-5">
                <h3 class="mb-4" style="color: #3d3d3d;">Utwórz kod kreskowy w dowolnym typie</h3>
                <form action="/generateWebpBarcode" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" id="barcode_text" name="barcode_text"
                            placeholder="Wprowadź kod kreskowy" value="{{ old('barcode_text') }}">
                    </div>
                    <div class="mb-3">
                        <?php
                        $barcodeTypes = ['TYPE_CODE_32', 'TYPE_CODE_39', 'TYPE_CODE_39_CHECKSUM', 'TYPE_CODE_39E', 'TYPE_CODE_39E_CHECKSUM', 'TYPE_CODE_93', 'TYPE_STANDARD_2_5', 'TYPE_STANDARD_2_5_CHECKSUM', 'TYPE_INTERLEAVED_2_5', 'TYPE_INTERLEAVED_2_5_CHECKSUM', 'TYPE_CODE_128_A', 'TYPE_CODE_128_B', 'TYPE_CODE_128_C', 'TYPE_EAN_2', 'TYPE_EAN_8', 'TYPE_EAN_13', 'TYPE_UPC_A', 'TYPE_UPC_E', 'TYPE_MSI', 'TYPE_MSI_CHECKSUM', 'TYPE_POSTNET', 'TYPE_KIX', 'TYPE_RMS4CC', 'TYPE_IMB', 'TYPE_CODABAR', 'TYPE_CODE_11', 'TYPE_PHARMA_CODE', 'TYPE_PHARMA_CODE_TWO_TRACKS'];
                        ?>
                        <select class="form-select" name="barcode_type" aria-label="Default select example">
                            <option disabled selected>Wybierz typ kodu kreskowego</option>
                            @foreach ($barcodeTypes as $barcodeType)
                                <option value="{{ $barcodeType }}"
                                    {{ $barcodeType === old('barcode_type') ? 'selected' : '' }}>{{ $barcodeType }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <input type="number" class="form-control" id="barcode_width" name="barcode_width"
                                    placeholder="Szerokość np. 5" value="{{ old('barcode_width') }}">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control" id="barcode_height" name="barcode_height"
                                    placeholder="Wysokość (px) np. 50" value="{{ old('barcode_height') }}">
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success ">Generuj do formatu WebP</button>
                    </div>
                </form>

                @if ($errors->any())
                    <div class="alert alert-danger mt-4" role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif

                <div class="alert alert-secondary mt-4" role="alert">
                    <span class="text-success">Wskazówka</span>: szerokość jest oparta na długości danych, dzięki temu
                    współczynnikowi możesz sprawić, że
                    paski kodu kreskowego będą szersze niż domyślnie.
                </div>
            </div>
        </div>
    </div>
@endsection
