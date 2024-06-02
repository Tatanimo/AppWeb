import React from "react";

export default function FirstHeader({content, color, className}) {
    return (
        <h1 className={`font-ChunkFive uppercase pb-5 xl:text-7xl text-3xl sm:text-5xl ${className} text-${color} `}>
            {content}
        </h1>
    );
}