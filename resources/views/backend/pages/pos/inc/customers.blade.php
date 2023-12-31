<div class="modal-header border-bottom-0 pb-0">
    <h2 class="modal-title h5" id="addCustomerLabel">{{ localize('Client existant') }}</h2>
    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body mb-3">
    <form action="#" class="existing-customer-form">
        @csrf
        <div class="mb-2">
            <label class="form-label">{{ localize('Sélectionner Client') }}</label>
            <select class="form-select modalSelect2 w-100" name="pos_customer_id" required>
                <option value="">{{ localize('Sélectionner un client dans la liste') }}</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->email }} -
                        {{ $customer->phone }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label for="customerAddress" class="form-label">{{ localize('Adresse') }}</label>
            <textarea class="form-control" name="pos_customer_address" id="customerAddress"
                placeholder="{{ localize('Addresse du Client') }}"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">{{ localize('Sélectionner') }}</button>
    </form>
</div>

<div class="modal-body">
    <h2 class="modal-title h5 mb-3" id="addCustomerLabel">{{ localize('Ajouter Nouveau Client') }}</h1>
        <form action="#" class="pos-new-customer">
            @csrf
            <div class="row g-3">
                <div class="col-12 col-sm-6">
                    <div class="mb-0">
                        <label for="customerName" class="form-label">{{ localize('Nom du client') }}</label>
                        <input class="form-control" type="text" id="customerName" name="new_pos_customer_name"
                            placeholder="{{ localize('Saisir Nom du client') }}" required>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="mb-0">
                        <label for="customerPhone" class="form-label">{{ localize('Numéro de téléphone') }}</label>
                        <input class="form-control" type="text" id="customerPhone" name="new_pos_customer_phone"
                            placeholder="{{ localize('Saisir Numéro de téléphone') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-0">
                        <label for="customerEmail" class="form-label">{{ localize('Email') }}</label>
                        <input class="form-control" type="email" id="customerEmail" name="new_pos_customer_email"
                            placeholder="{{ localize('Saisir email du Client') }}">
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-2">
                        <label for="new_customer_address" class="form-label">{{ localize('Adresse') }}</label>
                        <textarea class="form-control" name="new_customer_address" id="new_customer_address"
                            placeholder="{{ localize('Addresse du Client') }}"></textarea>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-0">
                        <button type="submit"
                            class="btn btn-primary save-select-btn">{{ localize('Enregistrer et Sélectionner') }}</button>
                    </div>
                </div>
            </div>
        </form>
</div>
