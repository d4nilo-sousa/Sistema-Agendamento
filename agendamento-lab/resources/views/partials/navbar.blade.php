<nav class="bg-purple-700 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            <!-- Logo / Nome do sistema -->
            <a href="/" class="flex items-center space-x-2">
                <i class="ri-flask-line text-2xl"></i>
                <span class="text-lg font-semibold tracking-wide">Sistema de Agendamento</span>
            </a>

            <!-- Menu Desktop -->
            <ul class="hidden md:flex items-center space-x-8 text-sm font-medium">

                <li><a href="/" class="hover:text-purple-200">Início</a></li>
                <li><a href="/places" class="hover:text-purple-200">Meus Espaços</a></li>
                <li><a href="/places/new" class="hover:text-purple-200">Novos Espaços</a></li>
                <li><a href="/scheduling" class="hover:text-purple-200">Agendamentos</a></li>

                <!-- Usuário -->
                <li class="relative">
                    <button onclick="toggleUserMenu()" class="flex items-center space-x-2 hover:text-purple-200 focus:outline-none">
                        <i class="ri-user-3-line text-xl"></i>
                        <span>{{ auth()->user()->name }}</span>
                        <i class="ri-arrow-down-s-line text-lg"></i>
                    </button>

                    <!-- Dropdown -->
                    <div id="userMenu"
                         class="hidden absolute right-0 mt-2 w-40 bg-white text-gray-700 rounded-lg shadow-lg py-2 z-50">

                        <span class="block px-4 py-2 text-sm font-semibold text-purple-700">
                            {{ auth()->user()->name }}
                        </span>

                        <a href="/logout"
                           class="flex items-center px-4 py-2 text-sm hover:bg-purple-100 text-red-600">
                            <i class="ri-logout-box-r-line mr-2"></i> Sair
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Botão Mobile -->
            <button class="md:hidden text-white text-2xl focus:outline-none" onclick="toggleMobileMenu()">
                <i class="ri-menu-line"></i>
            </button>

        </div>
    </div>

    <!-- Menu Mobile -->
    <div id="mobileMenu" class="md:hidden hidden bg-purple-600 px-6 pb-4 text-sm font-medium">

        <a href="/" class="block py-2 hover:text-purple-200">Início</a>
        <a href="/places" class="block py-2 hover:text-purple-200">Meus Espaços</a>
        <a href="/places/new" class="block py-2 hover:text-purple-200">Novos Espaços</a>
        <a href="/scheduling" class="block py-2 hover:text-purple-200">Agendamentos</a>

        <div class="border-t border-purple-400 my-2 pt-2">
            <div class="flex items-center space-x-2 text-white font-semibold">
                <i class="ri-user-3-line"></i>
                <span>{{ auth()->user()->name }}</span>
            </div>

            <a href="/logout" class="block mt-2 text-red-200 hover:text-red-300">Sair</a>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    }

    function toggleUserMenu() {
        document.getElementById('userMenu').classList.toggle('hidden');
    }

    // Fecha dropdown clicando fora
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('userMenu');
        const button = e.target.closest('button');
        if (!button) menu.classList.add('hidden');
    });
</script>
