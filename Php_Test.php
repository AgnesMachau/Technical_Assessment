1. Authentication
# Install Laravel
composer create-project --prefer-dist laravel/laravel your_project_name
cd your_project_name

# Install Laravel UI Package
composer require laravel/ui

# Generate Authentication Scaffolding
php artisan ui bootstrap --auth

# Install NPM Dependencies
npm install
npm run dev

# Run Migrations
php artisan migrate

2. Authorization
# Install Spatie Laravel Permissions
composer require spatie/laravel-permission

# Run Migrations
php artisan migrate

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
}
use Illuminate\Support\Facades\Gate;

public function boot()
{
    $this->registerPolicies();

    Gate::before(function ($user, $ability) {
        return $user->hasRole('admin') ? true : null;
    });
}
3. Information Exchange
# Create a Controller
php artisan make:controller ResourceController
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function index()
    {
        // Return a list of resources
    }

    public function show($id)
    {
        // Return a specific resource
    }

    public function store(Request $request)
    {
        // Store a new resource
    }

    public function update(Request $request, $id)
    {
        // Update a specific resource
    }

    public function destroy($id)
    {
        // Delete a specific resource
    }
}
Route::resource('resources', ResourceController::class);
4. Frontend integration with API
#HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Frontend API Integration</title>
</head>
<body>

    <div id="app">
        <h1>Resource Management</h1>

        <!-- Display Resources -->
        <div>
            <h2>Resource List</h2>
            <ul id="resourceList"></ul>
        </div>

        <!-- Create Resource -->
        <div>
            <h2>Create Resource</h2>
            <form id="createForm">
                <label for="name">Name:</label>
                <input type="text" id="name" required>
                <button type="submit">Create</button>
            </form>
        </div>

        <!-- Update Resource -->
        <div>
            <h2>Update Resource</h2>
            <form id="updateForm">
                <label for="updateId">Resource ID:</label>
                <input type="number" id="updateId" required>
                <label for="updateName">New Name:</label>
                <input type="text" id="updateName" required>
                <button type="submit">Update</button>
            </form>
        </div>

        <!-- Delete Resource -->
        <div>
            <h2>Delete Resource</h2>
            <form id="deleteForm">
                <label for="deleteId">Resource ID:</label>
                <input type="number" id="deleteId" required>
                <button type="submit">Delete</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>

#CSS

body {
    font-family: Arial, sans-serif;
    margin: 20px;
}

#app {
    max-width: 800px;
    margin: 0 auto;
}

form {
    margin-bottom: 10px;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    margin-bottom: 5px;
}

#Java Script

document.addEventListener('DOMContentLoaded', function () {
    const resourceList = document.getElementById('resourceList');
    const createForm = document.getElementById('createForm');
    const updateForm = document.getElementById('updateForm');
    const deleteForm = document.getElementById('deleteForm');

    // Function to fetch and display resources
    function fetchResources() {
        fetch('http://your-laravel-api-url/resources')
            .then(response => response.json())
            .then(data => {
                resourceList.innerHTML = '';
                data.forEach(resource => {
                    const listItem = document.createElement('li');
                    listItem.textContent = `ID: ${resource.id}, Name: ${resource.name}`;
                    resourceList.appendChild(listItem);
                });
            })
            .catch(error => console.error('Error fetching resources:', error));
    }

    // Fetch and display resources on page load
    fetchResources();

    // Event listener for create form
    createForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const name = document.getElementById('name').value;

        fetch('http://your-laravel-api-url/resources', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name }),
        })
            .then(response => {
                if (response.ok) {
                    fetchResources(); // Refresh the list after creating a resource
                } else {
                    console.error('Failed to create resource');
                }
            })
            .catch(error => console.error('Error creating resource:', error));
    });

    // Event listener for update form
    updateForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const updateId = document.getElementById('updateId').value;
        const updateName = document.getElementById('updateName').value;

        fetch(`http://your-laravel-api-url/resources/${updateId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name: updateName }),
        })
            .then(response => {
                if (response.ok) {
                    fetchResources(); // Refresh the list after updating a resource
                } else {
                    console.error('Failed to update resource');
                }
            })
            .catch(error => console.error('Error updating resource:', error));
    });

    // Event listener for delete form
    deleteForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const deleteId = document.getElementById('deleteId').value;

        fetch(`http://127.0.0.1:8000/resources/${deleteId}`, {
            method: 'DELETE',
        })
            .then(response => {
                if (response.ok) {
                    fetchResources(); // Refresh the list after deleting a resource
                } else {
                    console.error('Failed to delete resource');
                }
            })
            .catch(error => console.error('Error deleting resource:', error));
    });
});


