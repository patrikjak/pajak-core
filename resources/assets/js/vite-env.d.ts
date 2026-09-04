declare module '*.scss';

interface PajakToastPayload {
    type?: string;
    title: string;
    message?: string;
}

interface PajakComponent {
    initAll?: (root?: ParentNode) => void;
    show?: (payload: PajakToastPayload) => void;
}

interface Window {
    Pajak?: Record<string, PajakComponent | undefined>;
    PajakCore?: {
        version: string;
    };
}
