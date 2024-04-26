import React from 'react'

export default function Profile({srcPath}) {
  console.log(srcPath);

    return (
      <>  
        {srcPath && <img src={srcPath} className="w-full h-full" alt="user image" />}
          <span className="absolute left-1/2 top-1/2 font-bolder text-5xl -translate-x-1/2 -translate-y-1/2 hidden group-hover:block">+</span>
      </>
    )
}
