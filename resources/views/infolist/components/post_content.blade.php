<div>
    <style>
        /* General Styling */
        .filament-display-post_content {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            /* color: #333; */
        }

        /* Headings */
        .filament-display-post_content h1, .filament-display-post_content h2, .filament-display-post_content h3,
        .filament-display-post_content h4, .filament-display-post_content h5, .filament-display-post_content h6 {
            margin-top: 1.2em;
            font-weight: bold;
        }
        .filament-display-post_content h1 { font-size: 2em; }
        .filament-display-post_content h2 { font-size: 1.75em; }
        .filament-display-post_content h3 { font-size: 1.5em; }
        .filament-display-post_content h4 { font-size: 1.25em; }
        .filament-display-post_content h5 { font-size: 1em; }
        .filament-display-post_content h6 { font-size: 0.875em; }

        /* Paragraphs */
        .filament-display-post_content p {
            margin: 0.8em 0;
        }

        /* Links */
        .filament-display-post_content a {
            color: #007bff;
            text-decoration: none;
        }
        .filament-display-post_content a:hover {
            text-decoration: underline;
        }

        /* Lists */
        .filament-display-post_content ul {
            list-style-type: disc; /* bullet points */
            margin: 1em 0 1em 1.5em;
        }

        .filament-display-post_content ol {
            list-style-type: decimal; /* numbers */
            margin: 1em 0 1em 1.5em;
        }

        .filament-display-post_content ul li, .filament-display-post_content ol li {
            margin: 0.5em 0;
        }

        /* Block Quotes */
        .filament-display-post_content blockquote {
            margin: 1em 0;
            padding: 0.5em 1em;
            border-left: 5px solid #ccc;
            color: #555;
            background: #f9f9f9;
        }

        /* Tables */
        .filament-display-post_content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1em 0;
        }
        .filament-display-post_content th, .filament-display-post_content td {
            border: 1px solid #ddd;
            padding: 0.5em;
        }
        .filament-display-post_content th {
            background: #f5f5f5;
            font-weight: bold;
        }
        .filament-display-post_content td {
            background: #fff;
        }

        /* Code Samples */
        .filament-display-post_content pre {
            background: #f4f4f4;
            border: 1px solid #ddd;
            padding: 1em;
            overflow: auto;
        }
        .filament-display-post_content code {
            background: #f4f4f4;
            padding: 0.2em 0.4em;
            border-radius: 3px;
        }

        /* Horizontal Rule */
        .filament-display-post_content hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 1.5em 0;
        }

        /* Inline Formatting */
        .filament-display-post_content b, .filament-display-post_content strong {
            font-weight: bold;
        }
        .filament-display-post_content i, .filament-display-post_content em {
            font-style: italic;
        }
        .filament-display-post_content u {
            text-decoration: underline;
        }

        /* Text Alignment */
        .filament-display-post_content .text-left {
            text-align: left;
        }
        .filament-display-post_content .text-right {
            text-align: right;
        }
        .filament-display-post_content .text-center {
            text-align: center;
        }
        .filament-display-post_content .text-justify {
            text-align: justify;
        }

        /* Colors */
        .filament-display-post_content .text-color {
            display: inline;
        }
        .filament-display-post_content .background-color {
            display: inline;
        }

        /* Emoticons (Optional, depending on usage) */
        .filament-display-post_content .emoticon {
            font-size: 1.2em;
        }
    </style>

    <div class="filament-display-post_content">
        {!! $state !!}
    </div>

</div>
