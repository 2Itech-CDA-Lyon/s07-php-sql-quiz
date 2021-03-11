<!-- layout/header -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">M2i Quiz</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="/">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/quiz">Jouer</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/create">Créer</a>
        </li>
      </ul>
      <div class="d-flex">
        <a class="btn btn-primary" href="/login">Se connecter</a>
        <form method="post" action="/logout">
          <button class="btn btn-secondary" type="submit">Se déconnecter</button>
        </form>      
      </div>
    </div>
  </div>
</nav>