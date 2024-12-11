<div class="container">
    <h1>Bienvenue</h1>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Ajoutez ici le contenu de votre page d'accueil -->
</div>
