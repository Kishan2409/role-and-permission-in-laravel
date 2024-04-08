    <!-- Main content -->
    <section class="content">
        <div class="card card-info collapsed-card">
            <div class="card-header">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <h3 class="card-title">{{ __('Profile Information') }}</h3>
                </button>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                    </button>
                </div>

            </div>

            <div class="card-body">
                {{ __("Update your account's profile information and email address.") }}
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>
                <form id="profileupdate" method="post" action="{{ route('profile.update') }}" class="mt-3 ">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="id" id="id" class="form-control"
                                placeholder="Enter User id" value="{{ $user->id }}">
                            <label for="name">{{ __('Name') }}<span class="text-danger ">*</span></label>
                            <input id="name" name="name" type="text" class="mt-1 form-control block w-full"
                                value="{{ old('name', $user->name) }}" autocomplete="name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="email">{{ __('Email') }}<span class="text-danger ">*</span></label>
                            <input id="email" name="email" type="email" class="mt-1 form-control block w-full"
                                value="{{ old('email', $user->email) }}" autocomplete="username">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <button type="submit" class="btn btn-info">{{ __('Save') }}</button>

                            {{-- @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                            @endif --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </section>
