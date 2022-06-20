<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un evenement') }}
        </h2>
    </x-slot>
<div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-xl p-6 bg-white border-b border-gray-200">
                   Prix: 10€ / Premium 15€
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto">
        <form action="{{ route('event.store') }}" method="post" id="form">
            @csrf

            <x-label for="title" value="Titre" />
            <x-input id="title" name="title" type="text" :value="old('title')"/>

            <x-label for="content" value="Contenu" />
            <textarea id="content" name="content" :value="old('content')"></textarea>

            <x-label for="premium" value="Premium ?" />
            <x-input id="premium" name="premium" type="checkbox" :value="old('premium')"/>

            <x-label for="starts_at" value="Date de démarrage" />
            <x-input id="starts_at" name="starts_at" type="date" :value="old('starts_at')"/>

            <x-label for="ends_at" value="Date de fin" />
            <x-input id="ends_at" name="ends_at" type="date" :value="old('ends_at')"/>

            <x-label for="tags" value="Les tags (séparés par une virgule)" />
            <x-input id="tags" name="tags" type="text" :value="old('tags')" />


            <x-input id="payment_method" name="payment_method" type="hidden" />
            
            <div id="card-element"></div>

            <div class="block mt-3">
                <x-button type="submit" id="submit-button">Créer mon évènement</x-button>
            </div>

        </form>
    </div>  


    @section('extra-js')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            const stripe = Stripe(" {{ env('STRIPE_KEY') }} ");

            const elements = stripe.elements();
            const cardElement = elements.create('card', {
                classes: {
                    base: 'StripeElement bg-white w-1/2 p-2 my-2 rounded-lg'
                }
            });

            cardElement.mount('#card-element');

            const cardButton = document.getElementById('submit-button');

            cardButton.addEventListener('click', async(e) => {
                e.preventDefault();

                const { paymentMethod, error } = await stripe.createPaymentMethod('card', cardElement);

                if (error) {
                    alert(error)
                } else {
                    document.getElementById('payment_method').value = paymentMethod.id;
                }

                document.getElementById('form').submit();

            });
        </script>

    @endsection


</x-app-layout>

