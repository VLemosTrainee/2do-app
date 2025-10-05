<!-- resources/views/components/application-logo.blade.php -->

@props(['class' => ''])

<!-- Logotipo para Modo Claro (visível por defeito, escondido no modo escuro) -->
<img {{ $attributes->merge(['class' => 'block dark:hidden ' . $class]) }}
     src="{{ asset('images/logo_fundoclaro_2do.png') }}"
     alt="2Do Logo">

<!-- Logotipo para Modo Escuro (escondido por defeito, visível no modo escuro) -->
<img {{ $attributes->merge(['class' => 'hidden dark:block ' . $class]) }}
     src="{{ asset('images/logo_fundoescuro_2do.png') }}"
     alt="2Do Logo">