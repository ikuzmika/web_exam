<x-layout>
    <x-slot name="title">
        {{ __('admin.users_title') }}
    </x-slot>

    <section class="page-header">
        <div>
            <h1>{{ __('admin.users_title') }}</h1>
            <p>{{ __('admin.users_description') }}</p>
        </div>
    </section>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="content-list">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                <tr>
                    <th>{{ __('admin.id') }}</th>
                    <th>{{ __('admin.name') }}</th>
                    <th>{{ __('admin.email') }}</th>
                    <th>{{ __('admin.phone') }}</th>
                    <th>{{ __('admin.change_info') }}</th>
                    <th>{{ __('admin.role') }}</th>
                    <th>{{ __('admin.blocked') }}</th>
                    <th>{{ __('admin.change_role') }}</th>
                    <th>{{ __('admin.block_unblock') }}</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            {{ $user->id }}
                        </td>

                        <td>
                            <input type="text"
                                   name="name"
                                   form="user-info-{{ $user->id }}"
                                   class="form-control"
                                   value="{{ $user->name }}"
                                   required>
                        </td>

                        <td>
                            <input type="email"
                                   name="email"
                                   form="user-info-{{ $user->id }}"
                                   class="form-control"
                                   value="{{ $user->email }}"
                                   required>
                        </td>

                        <td>
                            <input type="text"
                                   name="phone"
                                   form="user-info-{{ $user->id }}"
                                   class="form-control"
                                   value="{{ $user->phone }}">
                        </td>

                        <td>
                            <form id="user-info-{{ $user->id }}"
                                  method="POST"
                                  action="{{ route('admin.users.updateInfo', $user) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-primary btn-sm">
                                    {{ __('admin.save_info') }}
                                </button>
                            </form>
                        </td>

                        <td>
                            <span class="badge bg-secondary">
                                @if ($user->role === 'user')
                                    {{ __('admin.participant') }}
                                @elseif ($user->role === 'organizer')
                                    {{ __('admin.organizer') }}
                                @elseif ($user->role === 'admin')
                                    {{ __('admin.admin') }}
                                @else
                                    {{ ucfirst($user->role) }}
                                @endif
                            </span>
                        </td>

                        <td>
                            @if ($user->is_blocked)
                                <span class="badge bg-danger">
                                    {{ __('common.yes') }}
                                </span>
                            @else
                                <span class="badge bg-success">
                                    {{ __('common.no') }}
                                </span>
                            @endif
                        </td>

                        <td>
                            <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
                                @csrf
                                @method('PATCH')

                                <div class="d-flex gap-2">
                                    <select name="role" class="form-control">
                                        <option value="participant" @selected($user->role === 'user')>
                                            {{ __('admin.participant') }}
                                        </option>

                                        <option value="organizer" @selected($user->role === 'organizer')>
                                            {{ __('admin.organizer') }}
                                        </option>

                                        <option value="admin" @selected($user->role === 'admin')>
                                            {{ __('admin.admin') }}
                                        </option>
                                    </select>

                                    <button type="submit" class="btn btn-primary btn-sm">
                                        {{ __('admin.save_role') }}
                                    </button>
                                </div>
                            </form>
                        </td>

                        <td>
                            @if (auth()->id() === $user->id)
                                <span class="text-muted">
                                    {{ __('admin.current_admin') }}
                                </span>
                            @else
                                <form method="POST" action="{{ route('admin.users.block', $user) }}">
                                    @csrf
                                    @method('PATCH')

                                    @if ($user->is_blocked)
                                        <button type="submit" class="btn btn-success btn-sm">
                                            {{ __('admin.unblock') }}
                                        </button>
                                    @else
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('{{ __('admin.confirm_block') }}')">
                                            {{ __('admin.block') }}
                                        </button>
                                    @endif
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            {{ __('admin.no_users') }}
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-3">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</x-layout>
