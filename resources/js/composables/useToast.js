import { reactive } from 'vue'

const toasts = reactive([])
let _id = 0

export function useToast() {
    function add(message, type = 'info', duration = 4000) {
        const id = ++_id
        toasts.push({ id, message, type, leaving: false })
        if (duration > 0) {
            setTimeout(() => remove(id), duration)
        }
        return id
    }

    function remove(id) {
        const idx = toasts.findIndex(t => t.id === id)
        if (idx === -1) return
        toasts[idx].leaving = true
        setTimeout(() => {
            const i = toasts.findIndex(t => t.id === id)
            if (i !== -1) toasts.splice(i, 1)
        }, 220)
    }

    return {
        toasts,
        success: (msg, dur) => add(msg, 'success', dur),
        error:   (msg, dur) => add(msg, 'error',   dur),
        info:    (msg, dur) => add(msg, 'info',     dur),
        warning: (msg, dur) => add(msg, 'warning',  dur),
        remove,
    }
}