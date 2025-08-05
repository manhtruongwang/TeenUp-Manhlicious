import { ImgHTMLAttributes } from 'react';
import logo from '../../../storage/app/public/images/logo.png';

export default function AppLogoIcon(props: ImgHTMLAttributes<HTMLImageElement>) {
    return (
        <div className="flex items-center justify-center rounded-md bg-white/90 p-2">
            <img src={logo} alt="TeenUp" className="w-24" />
        </div>
    );
}
