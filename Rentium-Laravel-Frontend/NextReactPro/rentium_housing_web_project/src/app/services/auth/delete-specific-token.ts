const delete_specific_token = (token_name: string): void => 
{
    return window?.localStorage?.removeItem(token_name);
}

export default delete_specific_token;