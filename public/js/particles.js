// Animación de partículas en el fondo
class ParticlesBackground {
    constructor() {
        this.canvas = document.getElementById('particles-canvas');
        this.ctx = this.canvas.getContext('2d');
        this.particles = [];
        
        // Ajustar cantidad de partículas según el tamaño de pantalla
        this.isMobile = window.innerWidth < 768;
        this.isTablet = window.innerWidth >= 768 && window.innerWidth < 1024;
        this.particleCount = this.isMobile ? 50 : this.isTablet ? 80 : 120;
        
        this.mouse = {
            x: null,
            y: null,
            radius: this.isMobile ? 120 : 180
        };
        
        this.resize();
        this.init();
        this.animate();
        
        window.addEventListener('resize', () => {
            this.resize();
            this.updateDeviceType();
        });
        window.addEventListener('mousemove', (e) => this.handleMouseMove(e));
        window.addEventListener('touchmove', (e) => this.handleTouchMove(e));
        window.addEventListener('mouseleave', () => this.handleMouseLeave());
        window.addEventListener('touchend', () => this.handleMouseLeave());
    }
    
    updateDeviceType() {
        const wasMobile = this.isMobile;
        this.isMobile = window.innerWidth < 768;
        this.isTablet = window.innerWidth >= 768 && window.innerWidth < 1024;
        
        // Reiniciar partículas si cambió el tipo de dispositivo
        if (wasMobile !== this.isMobile) {
            this.particleCount = this.isMobile ? 50 : this.isTablet ? 80 : 120;
            this.mouse.radius = this.isMobile ? 120 : 180;
            this.particles = [];
            this.init();
        }
    }
    
    handleTouchMove(e) {
        if (e.touches.length > 0) {
            this.mouse.x = e.touches[0].clientX;
            this.mouse.y = e.touches[0].clientY;
        }
    }
    
    handleMouseMove(e) {
        this.mouse.x = e.clientX;
        this.mouse.y = e.clientY;
    }
    
    handleMouseLeave() {
        this.mouse.x = null;
        this.mouse.y = null;
    }
    
    resize() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
        
        // Reinicializar posiciones base de partículas existentes
        this.particles.forEach(particle => {
            if (particle.baseX > this.canvas.width) particle.baseX = this.canvas.width;
            if (particle.baseY > this.canvas.height) particle.baseY = this.canvas.height;
        });
    }
    
    init() {
        for (let i = 0; i < this.particleCount; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                baseX: 0,
                baseY: 0,
                radius: Math.random() * 1.5 + 0.5, // Partículas más pequeñas
                vx: (Math.random() - 0.5) * 0.3,
                vy: (Math.random() - 0.5) * 0.3,
                opacity: Math.random() * 0.6 + 0.3
            });
        }
        // Guardar posiciones base
        this.particles.forEach(particle => {
            particle.baseX = particle.x;
            particle.baseY = particle.y;
        });
    }
    
    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        
        this.particles.forEach(particle => {
            // Movimiento base
            particle.baseX += particle.vx;
            particle.baseY += particle.vy;
            
            if (particle.baseX < 0 || particle.baseX > this.canvas.width) particle.vx *= -1;
            if (particle.baseY < 0 || particle.baseY > this.canvas.height) particle.vy *= -1;
            
            // Interacción con el mouse - las partículas siguen al cursor
            if (this.mouse.x !== null) {
                let dx = this.mouse.x - particle.baseX;
                let dy = this.mouse.y - particle.baseY;
                let distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < this.mouse.radius) {
                    let forceDirectionX = dx / distance;
                    let forceDirectionY = dy / distance;
                    let force = (this.mouse.radius - distance) / this.mouse.radius;
                    let attractionX = forceDirectionX * force * 40;
                    let attractionY = forceDirectionY * force * 40;
                    
                    particle.x = particle.baseX + attractionX;
                    particle.y = particle.baseY + attractionY;
                } else {
                    particle.x = particle.baseX;
                    particle.y = particle.baseY;
                }
            } else {
                particle.x = particle.baseX;
                particle.y = particle.baseY;
            }
            
            // Dibujar partícula con efecto de brillo
            this.ctx.beginPath();
            this.ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
            this.ctx.fillStyle = `rgba(102, 126, 234, ${particle.opacity})`;
            this.ctx.fill();
            
            // Halo alrededor de la partícula
            this.ctx.beginPath();
            this.ctx.arc(particle.x, particle.y, particle.radius * 2, 0, Math.PI * 2);
            this.ctx.fillStyle = `rgba(102, 126, 234, ${particle.opacity * 0.2})`;
            this.ctx.fill();
        });
        
        // Conectar partículas cercanas - efecto red neuronal
        for (let i = 0; i < this.particles.length; i++) {
            for (let j = i + 1; j < this.particles.length; j++) {
                const dx = this.particles[i].x - this.particles[j].x;
                const dy = this.particles[i].y - this.particles[j].y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < 120) {
                    const opacity = 0.15 * (1 - distance / 120);
                    this.ctx.beginPath();
                    this.ctx.strokeStyle = `rgba(102, 126, 234, ${opacity})`;
                    this.ctx.lineWidth = 0.8;
                    this.ctx.moveTo(this.particles[i].x, this.particles[i].y);
                    this.ctx.lineTo(this.particles[j].x, this.particles[j].y);
                    this.ctx.stroke();
                }
            }
        }
        
        // Conectar partículas con el mouse
        if (this.mouse.x !== null) {
            this.particles.forEach(particle => {
                const dx = this.mouse.x - particle.x;
                const dy = this.mouse.y - particle.y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < this.mouse.radius) {
                    const opacity = 0.3 * (1 - distance / this.mouse.radius);
                    this.ctx.beginPath();
                    this.ctx.strokeStyle = `rgba(118, 75, 162, ${opacity})`;
                    this.ctx.lineWidth = 1.5;
                    this.ctx.moveTo(particle.x, particle.y);
                    this.ctx.lineTo(this.mouse.x, this.mouse.y);
                    this.ctx.stroke();
                }
            });
            
            // Dibujar punto del mouse
            this.ctx.beginPath();
            this.ctx.arc(this.mouse.x, this.mouse.y, 4, 0, Math.PI * 2);
            this.ctx.fillStyle = 'rgba(118, 75, 162, 0.6)';
            this.ctx.fill();
            
            this.ctx.beginPath();
            this.ctx.arc(this.mouse.x, this.mouse.y, 8, 0, Math.PI * 2);
            this.ctx.fillStyle = 'rgba(118, 75, 162, 0.2)';
            this.ctx.fill();
        }
        
        requestAnimationFrame(() => this.animate());
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new ParticlesBackground();
});
