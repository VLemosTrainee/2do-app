import './bootstrap';
import Alpine from 'alpinejs';

// Importa a biblioteca Typed.js
import Typed from 'typed.js';
window.Typed = Typed;

window.Alpine = Alpine;
Alpine.start();

// --- LÓgica de ANIMAÇÃO UNIFICADA ---

document.addEventListener('DOMContentLoaded', () => {
    // Animação de entrada para a Welcome Page
    const welcomeHeader = document.getElementById('welcome-header');
    if (welcomeHeader) {
        setTimeout(() => welcomeHeader.classList.remove('opacity-0'), 100);
    }
    document.querySelectorAll('.welcome-element').forEach(el => {
        el.classList.remove('opacity-0', 'translate-y-4');
    });

    // Animação para as páginas de Autenticação (Login/Registo/etc.)
    const authVisualColumn = document.getElementById('auth-visual-column');
    if (authVisualColumn) {
        setTimeout(() => authVisualColumn.classList.remove('opacity-0'), 100);
    }
    document.querySelectorAll('.auth-element').forEach(el => {
        el.classList.remove('opacity-0', 'translate-y-4');
    });

    // Iniciar Typed.js se o elemento existir
    const motivationalPhrase = document.getElementById('motivational-phrase');
    if (motivationalPhrase) {
        const phrases = [
            // Ritmo e Consistência
            "Encontre o seu ritmo. Conquiste o seu dia.",
            "Cada tarefa concluída é uma batida no ritmo do seu sucesso.",
            "A consistência é o compasso que guia a melodia da produtividade.",
            "Deixe que o seu dia flua como uma boa canção, tarefa a tarefa.",
            "Mantenha o ritmo. A cada passo, a meta fica mais próxima.",
            "Não perca a batida. Foque-se na próxima nota, na próxima tarefa.",
            "A sua rotina é a sua canção. Torne-a num sucesso.",

            // Harmonia e Foco
            "Transforme o caos em harmonia, uma tarefa de cada vez.",
            "A clareza mental é a melodia perfeita para um dia produtivo.",
            "Quando as suas ações e metas estão em harmonia, nada o pode parar.",
            "Concentre-se na melodia do momento: a tarefa que tem em mãos.",
            "Organize as suas tarefas e componha a sinfonia do seu sucesso.",
            "Encontre a harmonia entre o descanso e o trabalho.",

            // Superação e Crescendo
            "Cada desafio superado é um crescendo na sua jornada.",
            "Transforme a pressão num solo de guitarra inesquecível.",
            "O seu maior sucesso ainda não foi composto. Continue a escrever.",
            "A falha é apenas um ensaio para a sua grande performance.",
            "A vida é como jazz... é melhor quando se improvisa com um plano.",
            "Aumente o volume da sua ambição. Silencie o ruído da dúvida.",
            "Seja o maestro da sua própria vida.",

            // Clássicas
            "O futuro é composto pelas notas que você toca hoje.",
            "A jornada de mil milhas começa com uma única nota.",
            "A diferença entre o ordinário e o extraordinário é aquela pequena 'nota' extra.",
            "Não espere pela inspiração. Seja a inspiração.",
            "A sua atitude é o maestro da sua orquestra interior.",
            "Comece pequeno, sonhe grande.",
            "Um passo de cada vez constrói um caminho.",
            "A disciplina é a ponte entre metas e realizações.",
            "Não pare quando estiver cansado. Pare quando terminar.",
            "O sucesso é a soma de pequenos esforços repetidos dia após dia.",
            "Acredite em si mesmo e tudo será possível."
        ];

        // =================================================================
        // 1. ADICIONAR A FUNÇÃO DE SHUFFLE (ALGORITMO FISHER-YATES)
        // =================================================================
        function shuffle(array) {
            let currentIndex = array.length, randomIndex;

            // Enquanto houver elementos para embaralhar...
            while (currentIndex > 0) {
                // Escolha um elemento restante...
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex--;

                // E troque-o com o elemento atual.
                [array[currentIndex], array[randomIndex]] = [
                    array[randomIndex], array[currentIndex]];
            }

            return array;
        }


        const options = {
            // =================================================================
            // 2. CHAMAR A FUNÇÃO SHUFFLE PARA RANDOMIZAR AS FRASES
            // =================================================================
            strings: shuffle(phrases),
            typeSpeed: 50,
            backSpeed: 25,
            backDelay: 4000,
            startDelay: 500,
            loop: true,
            smartBackspace: true
        };
        new Typed('#motivational-phrase', options);
    }
});

// Animação de saída para transições suaves entre páginas
document.addEventListener('click', (e) => {
    const link = e.target.closest('.page-transition-link');
    if (link) {
        e.preventDefault();
        const destination = link.href;
        document.body.classList.add('opacity-0', 'transition-opacity', 'duration-500');
        setTimeout(() => {
            window.location.href = destination;
        }, 500);
    }
});

// Garante que a página não fica invisível ao usar o botão "Voltar" do browser
window.addEventListener('pageshow', (event) => {
    if (event.persisted) {
        document.body.classList.remove('opacity-0');
    }
});