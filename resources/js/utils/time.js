/**
 * resources/js/utils/time.js
 *
 * Single source of truth for date/time display across the app.
 * All functions accept a UTC ISO-8601 string and return a string
 * formatted in the app's local timezone (Africa/Johannesburg).
 *
 * Import what you need:
 *   import { fmtDateTime, fmtDateLong, fmtDateShort, fmtDateOnly } from '@/utils/time'
 */

export const APP_TZ = 'Africa/Johannesburg'

/**
 * Long form: "Friday, 15 May 2026, 03:30"
 * Used on booking detail pages.
 */
export const fmtDateLong = (iso) =>
    new Date(iso).toLocaleString('en-ZA', {
        timeZone: APP_TZ,
        weekday:  'long',
        day:      'numeric',
        month:    'long',
        year:     'numeric',
        hour:     '2-digit',
        minute:   '2-digit',
    })

/**
 * Short form: "Fri, 15 May, 03:30"
 * Used on list/request cards.
 */
export const fmtDateShort = (iso) =>
    new Date(iso).toLocaleString('en-ZA', {
        timeZone: APP_TZ,
        weekday:  'short',
        month:    'short',
        day:      'numeric',
        hour:     '2-digit',
        minute:   '2-digit',
    })

/**
 * Medium date: "15 May 2026"
 * Used in booking/wallet tables where the month name aids readability.
 */
export const fmtDateMedium = (iso) =>
    new Date(iso).toLocaleDateString('en-ZA', {
        timeZone: APP_TZ,
        day:   'numeric',
        month: 'short',
        year:  'numeric',
    })

/**
 * Date only: "2026/05/15"
 * Used on index/table rows where space is tight.
 */
export const fmtDateOnly = (iso) =>
    new Date(iso).toLocaleDateString('en-ZA', {
        timeZone: APP_TZ,
    })
