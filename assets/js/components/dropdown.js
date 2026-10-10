export function dropdown() {
    return {
        open: false,
        btnDropdown: 'bg-[#1E1E1E] text-white hover:bg-gray-700 hover:text-white focus:bg-gray-700 focus:text-white focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 focus:ring-offset-gray-800',
        toggle() {
            this.open = !this.open;
        }
    }
}
