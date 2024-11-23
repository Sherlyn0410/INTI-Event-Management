async function fetchNotifications() {
    try {
        const response = await fetch('fetchNotification.php'); // Replace with your endpoint
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching notifications:', error);
        return { notifications: [], unseen: false };
    }
}

function updateNotificationIcon(notifications, unseen) {
    const notificationIcon = document.querySelector('.material-symbols-outlined');
    if (notifications.length > 0) {
        notificationIcon.classList.add('has-notifications'); // Add a class to indicate there are notifications
    } else {
        notificationIcon.classList.remove('has-notifications');
    }

    if (unseen) {
        notificationIcon.classList.add('unseen-notifications'); // Add a class to indicate there are unseen notifications
    } else {
        notificationIcon.classList.remove('unseen-notifications');
    }
}

function generateNotificationHTML(notifications) {
    if (notifications.length === 0) {
        return '<div class="px-3 py-2 d-flex bg-light">No new notifications</div>';
    }

    return notifications.map(notification => `
        <div class="px-3 py-2 d-flex bg-light">
            <span class="material-symbols-outlined">${notification.icon}</span>
            <span>${notification.message}</span>
        </div>
    `).join('');
}

function updateNotificationDropdown(notifications) {
    const notificationDropdown = document.querySelector('.dropdown-menu-noti');
    notificationDropdown.innerHTML = `
        <div>
            <h6 class="px-3">Notifications</h6>
            <hr class="m-0">
            ${generateNotificationHTML(notifications)}
        </div>
    `;
}

function loadNavbar(activePage) {
    const pages = {
        home: 'index.php',
        browse: 'eventListing.php',
        create: 'createEvent.php',
        tickets: 'ticket.php',
        manage: 'manageEvent.php',
        profile: 'profile.php',
        login: 'login.php'
    };

    const isActive = (page) => activePage === page ? 'active' : '';

    // Use the passed variable
    const name = userName;

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
                        <span class="dropdown-toggle text-capitalize">${name}</span>
                    </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink" id="profileDropdownMenu">
                    <li><a class="dropdown-item ${isActive('manage')}"" href="${pages.manage}">Manage event</a></li>
                    <li><a class="dropdown-item" href="${pages.tickets}">Ticket</a></li>
                    <li><a class="dropdown-item" href="${pages.profile}">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" id="logoutButton">Log out</a></li>
                    </ul>
                </li>
                </ul>
            </div>
          </div>
        </div>
      </nav>
    `;
}

function loadFooter() {
    const footerHTML = `
        <footer class="footer py-2">
            <div class="container text-center">
                <span>&copy; 2024 INTI Event Management. All rights reserved.</span>
            </div>
        </footer>
    `;
    document.body.insertAdjacentHTML('beforeend', footerHTML);
}

document.addEventListener('DOMContentLoaded', async function() {
    // Add event listener for the logout button
    const logoutButton = document.getElementById('logoutButton');
    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = 'logout.php';
            }
        });
    }

    // Add event listener for the profile picture edit button
    const editButton = document.getElementById('editButton');
    if (editButton) {
        editButton.addEventListener('click', function() {
            document.getElementById('inputGroupFile04').click();
        });
    }

    // Add event listener for the exit button in createEvent.php
    const exitButton = document.getElementById('exitButton');
    if (exitButton) {
        exitButton.addEventListener('click', function() {
            var form = document.getElementById('createEventForm');
            var formElements = form.elements;
            var hasValue = false;

            // Check if any form field has a value
            for (var i = 0; i < formElements.length; i++) {
                if (formElements[i].type !== 'button' && formElements[i].value.trim() !== '' && formElements[i].value !== '') {
                    hasValue = true;
                    break;
                }
            }

            if (hasValue) {
                var confirmExit = confirm('Do you really want to exit?');
                if (confirmExit) {
                    // Clear form fields
                    form.reset();
                    // Redirect to index.php
                    window.location.href = 'index.php';
                }
            } else {
                // Redirect to index.php
                window.location.href = 'index.php';
            }
        });
    }

    // Set minimum date for startdate input
    const today = new Date();
    today.setDate(today.getDate() + 1); // Add one day to today's date
    const tomorrow = today.toISOString().split('T')[0];
    const startDateInput = document.getElementById('startdate');
    if (startDateInput) {
        startDateInput.setAttribute('min', tomorrow);
    }

    // Fetch and update notifications on page load
    const { notifications, unseen } = await fetchNotifications();
    updateNotificationIcon(notifications, unseen);
    updateNotificationDropdown(notifications);

    // Mark notifications as seen when the dropdown is opened
    const notificationIcon = document.querySelector('.material-symbols-outlined');
    notificationIcon.addEventListener('click', () => {
        fetch('markNotificationsSeen.php'); // Endpoint to mark notifications as seen
        notificationIcon.classList.remove('unseen-notifications');
    });

    // Load footer
    loadFooter();
});

// CSS to indicate notifications
const style = document.createElement('style');
style.innerHTML = `
  .material-symbols-outlined.has-notifications::after {
    content: '•';
    color: red;
    font-size: 1.5em;
    position: absolute;
    top: 0;
    right: 0;
  }
  .material-symbols-outlined.unseen-notifications::before {
    content: '•';
    color: red;
    font-size: 1.5em;
    position: absolute;
    top: 0;
    right: 0;
  }
`;
document.head.appendChild(style);
