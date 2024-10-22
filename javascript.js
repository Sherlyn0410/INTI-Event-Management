function loadNavbar(activePage) {
    const pages = {
        home: 'index.html',
        browse: 'eventListing.html',
        create: 'createEvent.html',
        tickets: 'ticket.html',
        manage: 'manageEvent.html',
        profile: 'profile.html',
        login: 'login.html'
    };

    const isActive = (page) => activePage === page ? 'active' : '';

    document.getElementById('navbar-placeholder').innerHTML = `
      <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="${pages.home}">
            <img src="/INTIEventManagement/img/INTIlogo.png" width="206" height="44" class="d-none d-md-inline-block align-text-top" alt="INTILogo">
            <img src="/INTIEventManagement/img/INTImobilelogo.png" width="60" height="50" class="d-md-none d-inline-block align-text-top" alt="INTILogo">
          </a>
          <div class="d-lg-none d-flex align-items-center">
            <span role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-symbols-outlined">notifications</i></span>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                <div>
                    <h6 class="px-3">Notifications</h6>
                    <hr class="m-0">
                    <div class="px-3 py-2 d-flex bg-light">
                    <span class="material-symbols-outlined">campaign</span>
                    <span>Update: The date for antidrug campaign have changed to 28 Oct 2024</span>
                    </div>
                </div>
                </li>
            </ul>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          </div>
          <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <div>
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link d-flex ${isActive('home')}" href="${pages.home}"><i class="material-symbols-outlined">home</i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex ${isActive('browse')}" href="${pages.browse}"><i class="material-symbols-outlined">search</i>Browse events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex ${isActive('create')}" href="${pages.create}"><i class="material-symbols-outlined">add</i>Create an event</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex ${isActive('tickets')}" href="${pages.tickets}"><i class="material-symbols-outlined">confirmation_number</i>Tickets</a>
                </li>
                </ul>
            </div>
            <div>
                <ul class="navbar-nav">
                <li class="nav-item dropdown d-none d-lg-block"">
                    <a class="nav-link d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="material-symbols-outlined">notifications</i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-noti" aria-labelledby="navbarDropdownMenuLink">
                    <div>
                        <h6 class="px-3">Notifications</h6>
                        <hr class="m-0">
                        <div class="px-3 py-2 d-flex bg-light">
                        <span class="material-symbols-outlined">campaign</span>
                        <span>Update: The date for antidrug campaign have changed to 28 Oct 2024</span>
                        </div>
                    </div>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link ${isActive('profile')}" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <i class="material-symbols-outlined rounded-pill">person</i>
                        <span class="dropdown-toggle">Sherlyn Kuan Sin Ling</span>
                    </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink" id="profileDropdownMenu">
                    <li><a class="dropdown-item ${isActive('manage')}"" href="${pages.manage}">Manage event</a></li>
                    <li><a class="dropdown-item" href="${pages.tickets}">Ticket</a></li>
                    <li><a class="dropdown-item" href="${pages.profile}">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="${pages.login}">Log out</a></li>
                    </ul>
                </li>
                </ul>
            </div>
          </div>
        </div>
      </nav>
    `;
}

// Add event listener for the profile picture edit button
document.getElementById('editButton').addEventListener('click', function() {
    document.getElementById('inputGroupFile04').click();
});
