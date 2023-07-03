<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            更新パスワード
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            アカウントの安全性を確保するために、長くランダムなパスワードを使用してください。
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                現在のパスワード
            </label>
            <input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <span class="text-red-500">
                @foreach ($errors->updatePassword->get('current_password') as $message)
                {{ $message }}
                @endforeach
            </span>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                新しいパスワード
            </label>
            <input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <span class="text-red-500">
                @foreach ($errors->updatePassword->get('password') as $message)
                {{ $message }}
                @endforeach
            </span>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                パスワードの確認
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <span class="text-red-500">
                @foreach ($errors->updatePassword->get('password_confirmation') as $message)
                {{ $message }}
                @endforeach
            </span>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500">
                保存
            </button>

            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">保存しました。</p>
            @endif
        </div>
    </form>
</section>