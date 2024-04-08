    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-success">
            <div class="card-header">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <h3 class="card-title"> {{ __('Update Password') }}</h3>
                </button>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    {{-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button> --}}
                </div>
            </div>
            <div class="card-body">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}

                <form id="passwordupdate" method="post" action="{{ route('password.update') }}" class="mt-3">
                    @csrf
                    @method('put')
                    <div class="row ">
                        <div class="col-md-6">
                            <label for="update_password_current_password">{{ __('Current Password') }}<span
                                    class="text-danger ">*</span></label>
                            <input id="update_password_current_password" name="current_password" type="password"
                                class="mt-1 form-control block w-full" autocomplete="current-password"
                                placeholder="Enter Current Password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="update_password_password">{{ __('New Password') }}<span
                                    class="text-danger ">*</span></label>
                            <input id="update_password_password" name="password" type="password"
                                class="mt-1 form-control block w-full" autocomplete="new-password"
                                placeholder="Enter Password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="update_password_password_confirmation">{{ __('Confirm Password') }}<span
                                    class="text-danger ">*</span></label>
                            <input id="update_password_password_confirmation" name="password_confirmation"
                                type="password" class="mt-1 form-control block w-full" autocomplete="new-password"
                                placeholder="Enter Confirm Password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <button class="btn btn-success">{{ __('Update') }}</button>

                            {{-- @if (session('status') === 'password-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                            @endif --}}
                        </div>
                    </div>
                </form>
            </div>
    </section>
