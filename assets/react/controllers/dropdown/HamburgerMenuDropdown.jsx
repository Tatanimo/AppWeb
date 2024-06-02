import React, { useState } from 'react'
import { Menu, MenuHandler, MenuList, MenuItem, Button } from '@material-tailwind/react'

export default function HamburgerMenuDropdown({user, notifications}) {
    const [openBurger, setOpenBurger] = useState(false);

  return (
    <Menu open={openBurger} handler={setOpenBurger}>
        <MenuHandler>
            <Button className='shadow-none hover:shadow-none flex py-2 items-center bg-transparent overflow-hidden' >
                <div id="lines" className={`flex flex-col justify-around h-full px-4 scale-125 !p-2 ${openBurger ? "active -translate-x-0.5" : null}`}>
                    <div className="w-6 h-0.5 bg-black mb-1 transform transition-transform duration-200 origin-center"></div>
                    <div className="w-6 h-0.5 bg-black mb-1 opacity-100 transition-opacity duration-200"></div>
                    <div className="w-6 h-0.5 bg-black transform transition-transform duration-200 origin-center"></div>
                </div>
            </Button>
        </MenuHandler>
        <MenuList>
            <a href={`/about`}>
                <MenuItem>Qui sommes-nous</MenuItem>
            </a>
            <a href={`/services`}>
                <MenuItem>Services</MenuItem>
            </a>
            <a href={`#`}>
                <MenuItem>Blog</MenuItem>
            </a>
            <a href={`/contact`}>
                <MenuItem>Contact</MenuItem>
            </a>
            {user ? (
                <>
                    <hr className='my-2' />
                    <a href="/messages" className='relative'>
                        <MenuItem>Messagerie</MenuItem>
                        {notifications > 0 ? (
                        <div className="top-1 right-8 absolute rounded-full bg-red-300 p-2 flex justify-center items-center min-w-6 max-h-6">
                            <span className="top-[2px] right-[3px] z-10 absolute rounded-full bg-red-300 p-2 flex justify-center items-center animate-ping w-3/4 h-5/6"></span>
                            <span className="font-sans">{notifications}</span>
                        </div>
                        ) : null}
                    </a>
                </>
            ) : null}
        </MenuList>
    </Menu>
  )
}
