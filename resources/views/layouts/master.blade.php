<!DOCTYPE html>
<html lang="en">
    
    @include('layouts.partials.head')

    <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
        <div class="app-wrapper">
            
            @include('layouts.partials.navbar')
            
            @include('layouts.partials.sidebar')

            <main class="app-main">

                <div class="app-content">
                    @yield('content')
                </div>

            </main>

            @include('layouts.partials.footer')

            @include('layouts.partials.ai')
            @yield('script')
            
        </div>
    </body>
</html>