# Pulse Card Demo

There's a Laravel Pulse card that shows metrics from the Fly.io Metrics API.

**Files to care about**

1. `config/services.php` - See the `fly` key which expects an API token + organization
2. `app/Livewire/Requests.php` - Pulse card that grabs Fly Metrics so they can be used in the card
3. `resources/views/livewire/requests.blade.php` - A copy/paste/tweak of a standard Pulse card. The metrics data is converted as needed to show the graphs for HTTP requests over time
4. `app/Fly/*.php` - Files for talking to the Fly Metrics API and converting it something useful to the graphing library

## Running the App

1️⃣ Add the following to your `.env` (adjust as needed):

* `FLY_API_TOKEN=foo`
* `FLY_ORGANIZATION=personal`

(The `FLY_ORGANIZATION` value defaults to `personal` if you want to omit it).

2️⃣ Head to `app/Livewire/Requests.php` and undo the part where I hard-coded the Fly.io App `fideloper` (perhaps make that configurable, or find the app name via `FLY_APP_NAME`?)
