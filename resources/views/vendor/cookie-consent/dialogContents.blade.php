<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-2">
    <div class="max-w-7xl mx-auto px-6">
        <div class="p-2 rounded-lg bg-red-100">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 items-center hidden md:inline">
                    <p class="ml-3 text-red-700 cookie-consent__message">
                        {!! trans('cookie-consent::texts.message') !!}
                    </p>
                </div>
                <div class="mt-2 flex-shrink-0 w-full sm:mt-0 sm:w-auto">
                    <a class="js-cookie-consent-agree cookie-consent__agree flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-white bg-red-500 hover:bg-red-400">
                        {{ trans('cookie-consent::texts.agree') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
