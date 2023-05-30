const fetch_from_storage = (token_name: string): string | null => 
{
    return window?.localStorage?.getItem(token_name);
}

export default fetch_from_storage;