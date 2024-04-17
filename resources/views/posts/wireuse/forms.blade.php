## Usage

WireUse offers a set of traits that you can include on your [Livewire Forms](https://livewire.laravel.com/docs/forms).

The `Foxws\WireUse\Forms\Support\Form` class can be used to create a Livewire form:

```php
use Foxws\WireUse\Forms\Support\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;

class LoginForm extends Form
{
    protected static int $maxAttempts = 5;

    #[Validate]
    public string $email = '';

    #[Validate]
    public string $password = '';

    #[Validate]
    public bool $remember = false;

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'remember' => 'nullable|boolean',
            'password' => [
                'required',
                Password::defaults(),
            ],
        ];
    }

    protected function handle(): void
    {
        if (! Auth::attempt($this->only('email', 'password'), $this->remember)) {
            $this->addError('email', __('These credentials do not match our records'));

            return;
        }

        session()->regenerate();
    }

    protected function afterHandle(): mixed
    {
        return redirect()->intended();
    }
}
```

## Concerns

The following traits are included in `Foxws\WireUse\Forms\Support\Form`, but can also be used individually.

### WithForm

Located at `Foxws\WireUse\Forms\Concerns\WithForm`, this trait can be used to call and validate form attributes.

It offers methods like `getType`, `toCollection`, `toFluent`, `keys`, `get` (with fallback), `has`, etc.

### WithSession

Located at `Foxws\WireUse\Forms\Concerns\WithSession`, this trait can be used to restore and store form input as session data.

Depending on the usecase, one may use Livewire [session properties](https://livewire.laravel.com/docs/session-properties) instead.

The main benefits of our trait are that it offers validation recovery, and it can be used to store multiple values at once.


### WithThrottle

Located at `Foxws\WireUse\Forms\Concerns\WithThrottle`, this trait can be used to rate-limit form requests.

```php
use Foxws\WireUse\Forms\Concerns\WithThrottle;

class LoginForm extends Form
{
    use WithThrottle;

    protected static int $maxAttempts = 5;
}
```

### WithValidation

Located at `Foxws\WireUse\Forms\Concerns\WithValidation`, this trait can be used to validate form requests.

By setting `protected static bool $recoverable = true`, it will try to reset the form on validation errors.
This is useful on dynamic forms, which may change over time.
