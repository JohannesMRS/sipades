@once
    <style>
        .sipades-dashboard-widget-card {
            height: 100%;
            min-width: 0;
            padding: 1.25rem;
            border: 1px solid #e5e7eb;
            border-radius: .75rem;
            background: #fff;
            box-shadow: 0 1px 2px rgb(15 23 42 / .06);
        }

        .sipades-dashboard-widget-header {
            display: flex;
            align-items: flex-start;
            gap: .75rem;
            margin-bottom: 1rem;
        }

        .sipades-dashboard-widget-heading {
            min-width: 0;
        }

        .sipades-dashboard-widget-title {
            margin: 0;
            color: #17211b;
            font-size: 1rem;
            font-weight: 650;
            line-height: 1.4;
        }

        .sipades-dashboard-widget-description {
            margin: .2rem 0 0;
            color: #647067;
            font-size: .8125rem;
            line-height: 1.5;
        }

        .sipades-dashboard-widget-icon {
            display: inline-flex;
            width: 2.5rem;
            height: 2.5rem;
            flex: 0 0 2.5rem;
            align-items: center;
            justify-content: center;
            border-radius: .65rem;
            background: #f0fdf4;
            color: #166534;
        }

        .sipades-dashboard-widget-icon.is-warning {
            background: #fffbeb;
            color: #b45309;
        }

        .sipades-dashboard-widget-icon svg,
        .sipades-dashboard-row-icon svg,
        .sipades-dashboard-row-arrow svg,
        .sipades-dashboard-action svg {
            width: 1.15rem;
            height: 1.15rem;
        }

        .sipades-dashboard-checklist,
        .sipades-dashboard-news-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .sipades-dashboard-checklist-item,
        .sipades-dashboard-news-item {
            border-top: 1px solid #eef0ee;
        }

        .sipades-dashboard-checklist-item:first-child,
        .sipades-dashboard-news-item:first-child {
            border-top: 0;
        }

        .sipades-dashboard-checklist-link {
            display: flex;
            min-height: 3rem;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
            padding: .65rem 0;
            color: #344239;
            font-size: .875rem;
            line-height: 1.45;
            text-decoration: none;
            transition: color .15s ease;
        }

        .sipades-dashboard-checklist-link:hover,
        .sipades-dashboard-news-link:hover .sipades-dashboard-news-title {
            color: #166534;
        }

        .sipades-dashboard-checklist-label {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: .7rem;
        }

        .sipades-dashboard-row-icon {
            display: inline-flex;
            flex: 0 0 auto;
            color: #b45309;
        }

        .sipades-dashboard-row-arrow {
            display: inline-flex;
            flex: 0 0 auto;
            color: #9ca3af;
        }

        .sipades-dashboard-complete,
        .sipades-dashboard-empty {
            padding: .8rem .9rem;
            border-radius: .6rem;
            font-size: .875rem;
            line-height: 1.5;
        }

        .sipades-dashboard-complete {
            display: flex;
            align-items: center;
            gap: .65rem;
            background: #f0fdf4;
            color: #166534;
            font-weight: 600;
        }

        .sipades-dashboard-complete svg {
            width: 1.2rem;
            height: 1.2rem;
            flex: 0 0 auto;
        }

        .sipades-dashboard-empty {
            background: #f8faf9;
            color: #647067;
        }

        .sipades-dashboard-news-item {
            padding: .8rem 0;
        }

        .sipades-dashboard-news-link {
            display: block;
            color: inherit;
            text-decoration: none;
        }

        .sipades-dashboard-news-main {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .75rem;
        }

        .sipades-dashboard-news-title {
            min-width: 0;
            color: #26332b;
            font-size: .875rem;
            font-weight: 550;
            line-height: 1.45;
            overflow-wrap: anywhere;
            transition: color .15s ease;
        }

        .sipades-dashboard-news-status {
            flex: 0 0 auto;
            padding: .2rem .55rem;
            border-radius: 999px;
            background: #f3f4f6;
            color: #4b5563;
            font-size: .7rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .sipades-dashboard-news-status.is-published {
            background: #dcfce7;
            color: #166534;
        }

        .sipades-dashboard-news-status.is-draft {
            background: #fef3c7;
            color: #92400e;
        }

        .sipades-dashboard-news-date {
            display: block;
            margin-top: .25rem;
            color: #78827b;
            font-size: .75rem;
            line-height: 1.4;
        }

        .sipades-dashboard-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 12rem), 1fr));
            gap: .75rem;
        }

        .sipades-dashboard-action {
            display: flex;
            min-height: 3.25rem;
            align-items: center;
            gap: .7rem;
            padding: .7rem .85rem;
            border: 1px solid #dfe5df;
            border-radius: .6rem;
            background: #fff;
            color: #344239;
            font-size: .875rem;
            font-weight: 600;
            line-height: 1.4;
            text-decoration: none;
            transition: border-color .15s ease, background .15s ease, color .15s ease;
        }

        .sipades-dashboard-action:hover {
            border-color: #86c99b;
            background: #f0fdf4;
            color: #166534;
        }

        .sipades-dashboard-action svg {
            flex: 0 0 auto;
            color: #166534;
        }

        @media (max-width: 640px) {
            .sipades-dashboard-widget-card {
                padding: 1rem;
            }

            .sipades-dashboard-news-main {
                flex-wrap: wrap;
            }
        }
    </style>
@endonce
