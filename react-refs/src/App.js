import {useEffect, useRef, useState} from "react";
export default function App() {
    const [name, setName] = useState('')
    const inputRef = useRef(null)
    const renderCount = useRef(0)
    const previousName = useRef(null)
    useEffect(() => {
        renderCount.current = renderCount.current + 1
    })
    function focus(){
        inputRef.current.focus()
        inputRef.current.value = 'Some value'
    }
    console.log(inputRef)
    useEffect(() => {
        previousName.current = name
    }, [name])
    return (
        <>
            <input ref={inputRef} value={name} onChange={e => setName(e.target.value)} />
            <div> My name is {name} </div>
            <div>I rendered {renderCount.current} times</div>
            <button onClick={focus}></button>
            <div>{previousName.current} => {name}</div>
        </>
    )
}