export function notification() {
    return {
        show: true,
        init() {
            setTimeout(() => this.show = false, 4000);
        },
        close() {
            this.show = false;
        }
    };
}
