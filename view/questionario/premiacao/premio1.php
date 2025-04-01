<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explosão de Confetes</title>

    <!-- Importando o GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <link rel="stylesheet" href="../../../assets/premiacao.css">
</head>
<body>
    <div class="containerPremiacao">
        <div class="containerImgPremiacao">
            <img src="../../../assets/img/trofeu.png" alt="">

            <div id="emitter"></div>
        </div>
        <div class="containerDescricaoPremiacao">
            <span>Parabéns equipe, você passou a primeira página, seu prêmio é:</span>
        </div>  
        <div class="containerBtn">
        </div>
    </div>

    <script>
        var emitterSize = 100,
        dotQuantity = 100,  // Mais confetes para uma explosão maior
        dotSizeMin = 6,
        dotSizeMax = 12,  // Tamanho maior para os confetes
        speed = 3,  // Aumento da velocidade dos confetes
        gravity = 0.8,  // Aumento da gravidade
        explosionQuantity = 1,  // Menos explosões para facilitar o controle
        emitter = document.querySelector('#emitter'),
        explosions = [],
        currentExplosion = 0,
        container, i, move;

        function createExplosion(container) {
            var tl = gsap.timeline({paused: true}),  
            dots = [],
            angle, duration, length, dot, size, r, g, b;
            
            for (i = 0; i < dotQuantity; i++) {
                dot = document.createElement('div');
                dots.push(dot);
                dot.className = 'dot';
                r = getRandom(30, 255);
                g = getRandom(30, 230);
                b = getRandom(30, 230);
                gsap.set(dot, {
                    backgroundColor: 'rgb('+r+','+g+','+b+')',
                    visibility: 'hidden'
                });
                size = getRandom(dotSizeMin, dotSizeMax);
                container.appendChild(dot);
                angle = getRandom(0, 2 * Math.PI);  // Distribuição 360 graus
                length = Math.random() * (emitterSize * 3 - size / 2);  // Maior dispersão
                duration = 4 + Math.random();  // Aumentando o tempo de animação para uma explosão mais longa
    
                gsap.set(dot, {
                    x: Math.cos(angle) * length, 
                    y: Math.sin(angle) * length, 
                    width: size, 
                    height: size, 
                    xPercent: -50, 
                    yPercent: -50,
                    visibility: 'hidden',
                    force3D: true
                });
    
                tl.to(dot, duration / 2, {
                    opacity: 0,
                    ease: "power2.out"
                }, 0)
                .to(dot, duration, {
                    visibility: 'visible',
                    rotationX: '-=' + getRandom(720, 1440),
                    rotationZ: '+=' + getRandom(720, 1440),
                    x: "+=" + (Math.random() * 1200 - 600),  // Aumento da dispersão no eixo X
                    y: "+=" + (Math.random() * 1200 - 600),  // Aumento da dispersão no eixo Y
                    opacity: 1,
                    scale: 0.5 + Math.random(),
                    ease: "power3.out"
                }, 0)
                .to(dot, 1.25 + Math.random(), {
                    opacity: 0,
                    onComplete: function() {
                        // Garantindo que os confetes desapareçam completamente ao final
                        gsap.set(this.target, {visibility: 'hidden', x: 0, y: 0});
                    }
                }, duration / 2);
            }
    
            return tl;
        }

        function explode() {
            var explosion = explosions[currentExplosion];
            gsap.set(explosion.container, {
                x: window.innerWidth / 2 - emitterSize / 2,  // Centraliza na tela
                y: window.innerHeight / 2 - emitterSize / 2
            });
            explosion.animation.restart();
        }

        function getRandom(min, max) {
            return min + Math.random() * (max - min);
        }

        function setup() {
            // Cria e configura as explosões
            for (i = 0; i < explosionQuantity; i++) {
                container = document.createElement('div');
                container.className = 'dot-container';
                document.body.appendChild(container);
                explosions.push({
                    container: container,
                    animation: createExplosion(container)
                });
            }

            // Faz a primeira explosão ocorrer imediatamente
            explode();

            // Faz a explosão ocorrer em um intervalo contínuo (a cada 3.5 segundos)
            setInterval(explode, 3500);  // 3500 ms = 3.5 segundos
        }

        setup();
    </script>

</body>
</html>