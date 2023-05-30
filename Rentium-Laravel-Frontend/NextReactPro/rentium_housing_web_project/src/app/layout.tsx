import './globals.css'
//import { Inter } from 'next/font/google'
import clsx from 'clsx';

//global imports here:

//import global assets:
import '../../public/libs-templates-assets/assets/css/vendors/bootstrap/bootstrap.css';
import '../../public/libs-templates-assets/assets/css/w3.css';
import '../../public/libs-templates-assets/assets/css/color1.css';
import '../../public/libs-templates-assets/assets/css/animate.css';

//import global google font assets:
import {Roboto, Montserrat, Rubik} from 'next/font/google';

//set properties:
const roboto = Roboto({
  weight: ['400', '500', '700'],
  subsets: ['latin'],
  display: 'swap'
});

const montserrat = Montserrat({
  weight: ['400', '500', '600', '700', '800'],
  subsets: ['latin']
});

const rubik = Rubik({
  weight: ['400', '500','700'],
  subsets: ['latin'],
});

//const inter = Inter({ subsets: ['latin'] })

//the metadata in the header:
export const metadata = {
  title: 'Hometium',
  description: 'Rent and lease properties at convienience!',
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="en">
      {/*Shared codes:*/}
      <body className={clsx('container', montserrat.className, rubik.className, roboto.className)}>{children}</body>
    </html>
  )
}
