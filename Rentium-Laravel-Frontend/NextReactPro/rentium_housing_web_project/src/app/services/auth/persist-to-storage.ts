//this is used to persist token recieved via any auth endpoint into the frontend client-side storage:
const persist_to_storage = (token_name: string, token_value: string | number): void => 
{
    window?.localStorage?.setItem(token_name, token_value as string);
}

export default persist_to_storage;