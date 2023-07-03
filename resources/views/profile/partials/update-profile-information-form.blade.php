<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            プロフィール変更
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">

        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                名前
            </label>
            <input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <span class="text-red-500">
                @foreach ($errors->get('name') as $message)
                {{ $message }}
                @endforeach
            </span>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                メールアドレス
            </label>
            <input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <span class="text-red-500">
                @foreach ($errors->get('email') as $message)
                {{ $message }}
                @endforeach
            </span>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    メールアドレスが確認されていません。

                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        再送信するにはここをクリックしてください。
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    新しい確認メールがメールアドレスに送信されました。
                </p>
                @endif
            </div>
            @endif
        </div>
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                住所
            </label>
            <input id="address" name="address" type="text" class="mt-1 block w-full" value="{{ old('address', $user->address) }}" required autofocus autocomplete="address" />
            <span class="text-red-500">
                @foreach ($errors->get('address') as $message)
                {{ $message }}
                @endforeach
            </span>
        </div>


        <div class="flex items-center gap-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500">
                保存
            </button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">保存しました。</p>
            @endif
        </div>
    </form>
</section>